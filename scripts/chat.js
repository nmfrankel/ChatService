let msgs = document.getElementById('msgs'),
form = document.getElementById('newMsg'),
latestData = null,
refresh = true

// load previous messages in thread
window.onload = (()=>{
	form.recip.value = urlParam('thread')// set form recipient val
	loadMessages()
})

// load this chats messages or any new unread ones
async function loadMessages(){
	await fetch(`./api/cluster/${urlParam('thread')}`)
	.then(res => res.json())
	.then(json => {
		console.log(json)

		// prevent same messages from being inserted twice
		if(latestData===json.fingerprint || !json.fetched || json.resCode!==200 || !refresh) return
		latestData = json.fingerprint

		json.messages.forEach((msg, index) => {

			if(index==0 || (json.messages[index-1].sender != msg.sender || !json.messages[index-1])){
				let newSegment = document.createElement('div')
				newSegment.classList.add(msg.sender==form.sender.value? 'othersMsg': 'yourMsg')
				msgs.insertAdjacentElement('beforeend', newSegment)
			}

			let msgContainer = document.createElement('div')
			msgContainer.classList.add('msgContainer')

			let newMsg = document.createElement('div')
			newMsg.id = msg.id
			newMsg.classList.add('msg')
			// newThread.setAttribute('onclick')// show time sent
			newMsg.innerHTML = `${msg.content}`

			msgContainer.append(newMsg)
			msgs.lastChild.insertAdjacentElement('beforeend', msgContainer)


			/* 
			// msgs.append(newMsg)// check if theres a version to .append() at begining
			// msgs.insertAdjacentElement('afterbegin', newMsg)
			msgs.insertAdjacentElement('beforeend', newMsg)
			*/
		});
	})
	.catch(err => console.error(err))
}

// send a message to this chat/user
function postMsg(e){
	e.preventDefault()

	// prep msgData for sending
	let msgData = new FormData()
	for (let i = 0; i < form.elements.length; i++){
		if(form.elements[i].name.length) msgData.append(form.elements[i].name, form.elements[i].value)
	}

	fetch('./api/msg', {
		method: 'POST',
		body: msgData
	})
	.then(res => res.json())
	.then(json => {
		console.log(json)

		if(!msgs.lastChild.classList.contains('yourMsg')){
			let newSegment = document.createElement('div')
			newSegment.classList.add('yourMsg')
			msgs.insertAdjacentElement('beforeend', newSegment)
		}

		let msgContainer = document.createElement('div')
		msgContainer.classList.add('msgContainer')

		let newPost = document.createElement('div')
		newPost.id = json.id
		newPost.classList.add('msg')
		// newPost.setAttribute('onclick')// show time sent
		newPost.innerHTML = json.content
		// json.sender
		// json.content
		// json.read
		// json.time

		msgContainer.append(newPost)
		msgs.lastChild.insertAdjacentElement('beforeend', msgContainer)
	})
	.catch(err => console.error(err))
	form.reset()
}

// get url parameters | support ie
function urlParam(param){

	let regex = new RegExp("[\\?&]"+param+"=([^&#]*)")
	let searchTerm = regex.exec(window.location.href)

	if(searchTerm) return searchTerm[1]
}

// console.log(atob('c0hNaHR3Mw=='), btoa('Nosson'))