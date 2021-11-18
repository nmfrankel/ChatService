const msgs = document.getElementsByClassName('msgContainer')

let refresh = true,
lastLoad = null,
msgData = [],
form = document.forms[0]

// load data for the threads
loadMsgs = ()=>{
	fetch(`./api/cluster/${form.recip.value}`)
		.then(res => res.json())
		.then(json => {
			console.log(json)

			// prevent same messages from being inserted twice
			if(msgData===json.fingerprint || !json.fetched || json.resCode!==200 || !refresh) return
			msgData = json.fingerprint

			// set group title or other username
			chatTitle.innerText = json.chatTitle

			json.msgs?.forEach((msg, index) => {
				if(!json.msgs[index-1] || json.msgs[index-1].sender != msg.sender){
					let newSegment = buildElements(msg.sender==form.sender.value? '.outgoing': '.incoming')
					document.getElementsByClassName('active')[0].children[0].append(newSegment)
				}

				const msgsConatiner = document.getElementsByClassName('active')[0].children[0]
				let tempTest = buildElements(`.msgContainer>.msg[id=${msg.id}][onclick=false]`)
				// use this to prevent XSS {${msg.content}}, but handle on server to prevent display error
				tempTest.children[0].innerHTML = msg.content

				msgsConatiner.lastChild.insertAdjacentElement('beforeend', tempTest)
			})
		})
		.catch(err => console.error(err))
}
// go to threads page
function goBack(e){
	e?.preventDefault()
	ripple(e)
	form.classList.add('fadeOut')
	document.body.style.overflow = 'hidden'

	Array.from(msgs).reverse().map((child, i) => {
		child.style.animationDelay = 75+(15*i) + 'ms'
		child.classList.add('slideOutRight')
	})

	setTimeout(() => {
		document.getElementById('chat').classList.add('doubleCenter')
		document.getElementById('chat').children[0].innerText = 'Loading...'
		document.getElementsByTagName('header')[0].classList.add('fadeOut')
		window.location = '/threads'
	}, 250);
}

// after the page animate the page
window.onload = ()=>{
	if(urlParam('t') == undefined) window.location.href = './threads'
	form.recip.value = urlParam('t')
	// form.sender.value = 'read user cookie'

	loadMsgs()
	// setInterval(()=>{
	// 	loadMsgs()
	// }, 10000)
}