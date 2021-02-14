
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
	timeStr = `${timestamp.getMonth()+1}/${timestamp.getDate()}/${timestamp.getFullYear().toString().substr(-2)}`,
	tmZone = timestamp.getTimezoneOffset()*60000

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