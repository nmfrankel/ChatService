// load this page into ../messages.php
let threads = document.getElementById('threads'),
latestData = null,
refresh = true

async function loadThreads(){
	await fetch('./api/threads')
	.then(res => res.json())
	.then(json => {

		// prevent same messages from being inserted twice
		if(latestData===json.fingerprint || !json.fetched || json.resCode!==200 || !refresh) return
		latestData = json.fingerprint

		// only while in development
		let devTime = [new Date().getTime()-2000, new Date().getTime()-250000, new Date().getTime()-10000000]

		// go through messages to put them on the page
		json.threads.reverse().forEach(item => {
			let newThread = document.createElement('div')
			newThread.classList.add('thread')
			// newThread.id = item.id
			newThread.setAttribute('onclick', `openThread('${item.id}')`)
			newThread.innerHTML = `
				<span class='picContainer'>
					<img class='userPicture' src='/V1/chatpic/${item.imgLoc}.png'>
				</span>
				<span class='name'>${item.name}</span>
				<span class='lastMessage'>${item.lastMsg}</span>
				<!--<span class='time'>${readableTime(item.time)}</span>-->
				<span class='time'>${readableTime(devTime.pop())}</span>
				<span class="chevron"></span>`

			threads.insertAdjacentElement('afterbegin', newThread)
		});
	})
	.catch(err => console.error(err))
}
// load threads right away on page load
window.addEventListener('load', loadThreads())

// transform timestamp to readable date
function readableTime(timestamp){
// check if today
	// check if within an hour
	// show time unless after 10 hours then add 'am'
// check if within week
	// show 'tuesday'
// show date

	timestamp = new Date(timestamp)

	let now = new Date(),
	timeStr = `${timestamp.getMonth()+1}/${timestamp.getDate()}/${new Date().getFullYear().toString().substr(-2)}`,
	tmZone = now.getTimezoneOffset()*60000

	// check if message was sent today
	if(timestamp.getTime() > now.getTime()-tmZone - (now.getTime()-tmZone)%(60*60*24*1000)+tmZone){

		// set time message was sent
		let hour = timestamp.getHours()%12!=0? timestamp.getHours()%12: 12
		let min = timestamp.getMinutes()>10? timestamp.getMinutes(): '0'+timestamp.getMinutes()

		if(timestamp.getTime() > now.getTime()-(60*60*1*1000)){
			timeStr = 'Now'
		}else{
			// timeStr = 'Today'
			timeStr = `${hour}:${min}`
		}

	}else if(false){

	}

	return timeStr
}

// select a thread and view messages
function openThread(id){
	refresh = false
	threads.classList.add('slideOutLeft')
	setTimeout(() => {
		threads.innerHTML = '<div align="center">Loading...</div>'
		threads.classList.remove('slideOutLeft')
		window.location=`/chat?thread=${id}`
	}, 150);
}

// logout user and reroute them to the homepage
function logout(){
	refresh = false
	threads.classList.add('slideOutRight')
	// reset 'PHPSESSID' cookie
	// reset 'PHPSESSID' cookie
	setTimeout(() => {
		threads.innerHTML = '<div align="center">Logging out... please wait</div>'
		threads.classList.remove('slideOutRight')
		// window.location='/'
	}, 150);
}
