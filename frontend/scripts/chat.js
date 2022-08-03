const form = document.forms[0],
endpoint = './api/msgs/'+urlParam('handle'),
mainParent = document.getElementById('chat'),
msgContainers = document.getElementsByClassName('msgContainer')

let refresh = true,
msgData = [],
metadata = null

// go to threads page
const goBack = e=>{
	e?.preventDefault()
	refresh = 0
	ripple(e)
	form.classList.add('fadeOut')
	document.body.style.overflow = 'hidden'

	Array.from(msgContainers).reverse().map((child, i) => {
		child.style.animationDelay = 75+(15*i) + 'ms'
		child.classList.add('slideOutRight')
	})

	setTimeout(() => {
		document.getElementById('chat').classList.add('doubleCenter')
		document.getElementById('chat').innerText = 'Loading...'
		document.getElementsByTagName('header')[0].classList.add('fadeOut')
		window.location = '/threads'
	}, 250);
}

// Manage displaying messages to screen
const displayMsgs = ()=>{
	while(mainParent.firstElementChild) mainParent.firstElementChild.remove()

	msgData.forEach((msg, i) => {
		// wrap cluster of msgs together based on same sender
		if(msgData[i-1]?.sender !== msg.sender){
			const wrapper = buildElements(msg.sender==form.sender.value? '.outgoing': '.incoming')
			mainParent.append(wrapper)
		}

		// build and display msg component
		let markup = `.msgContainer>.msg[id=${msg.id}][onclick=false]{${new XMLSerializer().serializeToString(document.createTextNode(msg.content))}}`
		const msgComponent = buildElements(markup)
		mainParent.lastChild.append(msgComponent)

		// support HTML be passed in as content {} with an option to override default (safe) and insert as innerHTML
		// tempTest.children[0].innerHTML = msg.content
	})
}
// load new messages
const fetchData = ()=>{
	fetch(endpoint)
	.then(res => res.json())
	.then(json => {
		// skip if no new msgs
		// if(msgData===json.fingerprint || !json.fetched || json.resCode!==200 || !refresh) return

		// metadata = json.fingerprint
		chatTitle.innerText = json.chatTitle
		msgData = json.msgs// update doubles
		displayMsgs()
	})
	.catch(err => console.error(err))
}
// post a new message on chat
const postMsg = e=>{
	e?.preventDefault()
	e.submitter.blur()
	if(form.content.value === '') return

	const newMsg = new FormData()
	Array.from(form.elements).forEach(input => {
		if(input.name.length) newMsg.append(input.name, input.value)
	})

	fetch('./api/msgs/', {
		method: 'POST',
		body: newMsg
	})
	.then(res => res.json())
	.then(json => {
		console.log(json)

		if(!json.id) return

		// json.id
		// json.sender
		// json.content
		// json.read
		// json.time

		// check the msg wasn't loaded already through fetchData; for slow connections
		msgData.push(json)
		displayMsgs()
		form.reset()
	})
	.catch(err => console.error(err))
}

// init page
window.onload = ()=>{
	if(urlParam('handle') == undefined) window.location.href = './threads'
	form.recip.value = urlParam('handle')
	// form.sender.value = 'read user cookie'

	fetchData()
	setInterval(()=>{
		fetchData()
	}, 10000)
}