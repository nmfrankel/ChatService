document.body.insertAdjacentHTML('beforeend', "<div id='printEl'>This app requires JavaScript</div>");
var printEl = document.getElementById('printEl');
printEl.innerHTML='';

function print(str, len = 5000){
	printEl.innerHTML = "";
	setTimeout(function(){
		printEl.innerHTML = str;
		setTimeout(function(){
			printEl.innerHTML = "";
		}, len);
	}, 100);
}
// ripple effect on click
function ripple(event) {
	el = event.currentTarget;

	rippleEl = document.querySelector('span.ripple');
	if(!rippleEl) {
		rippleEl = document.createElement('span');
	}
	el.appendChild(rippleEl);

	max = Math.max(el.offsetWidth, el.offsetHeight);
	rippleEl.style.width = rippleEl.style.height = max + 'px';

	rect = el.getBoundingClientRect();
	rippleEl.style.left = event.clientX - rect.left - (max/2) + 'px';
	rippleEl.style.top = event.clientY - rect.top - (max/2) + 'px';

	rippleEl.classList.add('ripple');
}

// Fill header
document.getElementsByTagName('header')[0].innerText = document.getElementsByClassName('active')[0].id;