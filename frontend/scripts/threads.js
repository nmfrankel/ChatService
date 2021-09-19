const chatMsgsEl = document.getElementById('chats').children[0]

let refresh = true,
lastLoad = null,
threadData = []

// load data for the threads
loadThreads = ()=>{
	fetch('./api/threads')
		.then(res => res.json())
		.then(json => {
			// prevent same messages from being displayed twice
			if(lastLoad===json.fingerprint || !json.fetched || json.resCode!==200 || !refresh) return
			lastLoad = json.fingerprint
			// add new threads to threadData array

			json.threads.forEach(thread => {
				const newThread = buildElements(`a.thread${thread.new? '.unread': ''}[href][onclick=openThread('${thread.handle}', this, event)]`)

				imgFile = thread.img?.split('_')[0] === 'avatar'? `./images/${thread.img.split('_')[1]}.png`: `http://localhost/V1/chatpic/${thread.img}.png`
				const imgEl = buildElements(`div.imgContainer>${thread.img? `img[src=${imgFile}][onerror=this.style.display='none']`: ""}+div{${thread.name[0]}})`)
				newThread.append(imgEl)
				
				const msgData = buildElements(`div.userInfo>.recip{${thread.name}}+.lastMsg{${thread.lastMsg}}`)
				newThread.append(msgData)
				
				const timeInfo = buildElements(`div.metaData>.timestamp{${readableTime(thread.time)}}+.newCount{${thread.new}}`)
				newThread.append(timeInfo)

				chatMsgsEl.append(newThread)


				// const tempTest = buildElements(`a.thread${thread.new?'.unread':''}}[href][onclick=openThread('${thread.handle}', this, event)]>(div.imgContainer>${thread.imgLoc? `img[src=http://localhost/V1/chatpic/${thread.imgLoc}.png][onerror=this.style.display='none']`: ""}+div{${thread.name[0]}})+(div.userInfo>.recip{${thread.name}}+.lastMsg{${thread.lastMsg}})+(div.metaData>.timestamp{${readableTime(thread.time)}}+.newCount{${thread.new}})`)
				// chatMsgsEl.append(tempTest)
			})
			console.log(json)
		})
		.catch(err => console.error(err))
}

// open thread to view msgs
openThread = (id, thread, e)=>{
	e?.preventDefault()
	ripple(e)

	refresh = false
	if(thread.classList.contains('unread')) thread.classList.remove('unread')
	document.getElementsByTagName('header')[0].classList.add('fadeOut')
	Array.from(document.getElementsByClassName('thread')).forEach((el, i) => {
		// have selected msg slide out first and all follow in a "<" shape after it
		el.style.animationDelay = (i*33+50)+'ms'
		el.classList.add('slideOutLeft')
	});
	
	setTimeout(() => {
		document.getElementById('chats').classList.add('doubleCenter')
		document.getElementById('chats').children[0].innerText = 'Loading...'
		window.location = `./chat.html?t=${id}`
	}, 300);
}

// after the page animate the page
window.onload = ()=>{
	loadThreads()
	setInterval(()=>{
		loadThreads()
	}, 10000)
}