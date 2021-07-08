// logout user and reroute them to the homepage
function logout(){
	refresh = false
	document.getElementsByClassName('active')[0].classList.add('slideOutRight')
	document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";// reset session cookie
	setTimeout(() => {
		document.getElementsByClassName('active')[0].classList.add('doubleCenter')
		document.getElementsByClassName('active')[0].children[0].innerText = 'Please wait...'
		document.getElementsByClassName('active')[0].classList.remove('slideOutRight')
		window.location='/chat.beta.html'
	}, 150);
}

// transform timestamp to readable date
function readableTime(timestamp = new Date()){
	let currentTime = Math.floor(new Date().getTime()/1000),
	modTime = new Date(timestamp*1000),
	timeStr = 'Time error',// 'Unavailable',
	hr = modTime.getHours()%12!=0? modTime.getHours()%12: 12,
	min = modTime.getMinutes()>=10? modTime.getMinutes(): '0'+modTime.getMinutes(),
	meridian = modTime.getHours()<12? 'AM': 'PM'

	// recalculate once a min
	if(currentTime-60 < timestamp) timeStr = 'Now'// 'Under a min'
	else if(currentTime-43140 < timestamp || modTime.getDate() == new Date().getDate()) timeStr = `${hr}:${min} ${meridian}`
	else if(currentTime-172800 < timestamp && modTime.getDay()+7 == new Date().getDay()+6) timeStr = 'Yesterday'
	else if (currentTime-691200 < timestamp && modTime.getDate()+7 >= new Date().getDate()) timeStr = modTime.toLocaleString('en-us', {weekday: 'long'})
	else if (currentTime-2592000 < timestamp && modTime.getMonth() === new Date().getMonth()) timeStr = `${modTime.getMonth()+1}/${modTime.getDate()}`
	else timeStr = `${modTime.getMonth()+1}/${modTime.getDate()}/${modTime.getFullYear().toString().substr(-2)}`

	return timeStr
}
function ripple(event) {
	el = event.currentTarget

	rippleEl = document.querySelector('span.ripple')
	if(!rippleEl) rippleEl = document.createElement('span')
	el.appendChild(rippleEl)

	max = Math.max(el.offsetWidth, el.offsetHeight)
	rippleEl.style.width = rippleEl.style.height = max + 'px'

	rect = el.getBoundingClientRect()
	rippleEl.style.left = event.clientX - rect.left - (max/2) + 'px'
	rippleEl.style.top = event.clientY - rect.top - (max/2) + 'px'

	rippleEl.classList.add('ripple')
}

// take in emmet abbreviation and return JS element(s) | OG FROM: LiveCampaign
function buildElements(markup){
	let parentElement = document.createElement('span'),// parent holding all elements
	activeNode = parentElement,// where new node will append
	createList = `>${markup}`.match(/[\+>^~\(\)]*[^\+>^~]+(?<!\))/g),// create array of elements to create
	markedLevels = [0]// for supporting ()

	if(!createList) return 'Invalid markup entered'
	createList.forEach(blueprint => {
		// metadata for new node
		const tag = blueprint.match(/[\+>^~\(\)]*(\w*)/)?.[1] || 'div',
		id = blueprint.match(/#\w+/)?.[0],
		attributes = blueprint.match(/(?<=\[)([^\]]*)(?=\])/g) ?? [],
		classes = blueprint.match(/(?<=\.|class=)\w+/g) ?? [],
		content = blueprint.match(/\{.*\}/)?.[0]
		let multipleCopies = Number(blueprint.match(/(?<=\*)\d+/)?.[0])

		// create & set attributes
		let newNode = document.createElement(tag)
		if (id) newNode.id = id.slice(1)
		for (const attr of attributes) newNode.setAttribute(attr.split('=')[0], attr.split('=').slice(1).join('=') ?? '')
		for (const cls of classes) newNode.classList.add(cls)
		if (content) newNode.innerHTML = content.slice(1).slice(0, -1)

		// handle close parenthesis
		let levelDiff = 0
		while (blueprint[0] === ')' && activeNode.parentElement){
			levelDiff += markedLevels.pop() - markedLevels[markedLevels.length-1]
			blueprint = blueprint.slice(1)
		}
		while (levelDiff--) activeNode = activeNode.parentElement

		// append node under correct parent
		if(blueprint[0] === '>' && activeNode.children.length){
			activeNode = activeNode.lastChild
			blueprint = blueprint.slice(1)
			markedLevels[markedLevels.length-1]++
		}else if(blueprint[0] === '^'){
			while(blueprint[0] === '^' && activeNode.parentElement){
				activeNode = activeNode.parentElement
				markedLevels[markedLevels.length-1]--
				blueprint = blueprint.slice(1)
			}
		}else{
			blueprint = blueprint.slice(1)
		}
		if(blueprint.match(/[a-z]/i)?.[0]) activeNode.appendChild(newNode)

		// handle copies of an element
		while (--multipleCopies) activeNode.appendChild(activeNode.lastChild.cloneNode(true))

		// handle open parenthesis
		if(blueprint[0] === '('){
			blueprint = blueprint.slice(1)
			markedLevels.push(markedLevels[markedLevels.length-1])
		}
	})
	return parentElement.children.length===1? parentElement.firstChild: parentElement.childNodes
}
