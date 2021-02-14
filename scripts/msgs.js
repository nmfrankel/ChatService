// load this page into ../msgs.php
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
			if (item.new) newThread.classList.add('new')
			// newThread.handle = item.handle
			newThread.setAttribute('onclick', `openThread('${item.handle}')`)
			newThread.innerHTML = `
				<span class='picContainer'>
					<img class='userPicture' src='/V1/chatpic/${item.imgLoc}.png'>
				</span>
				<span class='name'>${item.name}</span>
				<span class='lastMsg'>${item.lastMsg}</span>
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

// select a thread and view messages
function openThread(id){
	refresh = false
	threads.classList.add('slideOutLeft')
	setTimeout(() => {
		threads.style.textAlign = 'center'
		threads.innerText = 'Loading...'
		window.location = `./chat?thread=${id}`
	}, 150);
}