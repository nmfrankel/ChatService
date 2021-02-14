// load this page into ../login.php
let form = document.forms[0]

Promise.all([...form.elements].map(input => {
	input.onchange = (()=>{
		if(input.value === "") input.classList.remove('filled')
		else input.classList.add('filled')
	})
}))

function login(e){
	e.preventDefault()

	// prep loginData for sending
	let loginData = new FormData()
	for (let i = 0; i < form.elements.length; i++){
		if(form.elements[i].name.length) loginData.append(form.elements[i].name, form.elements[i].value)
	}

	fetch('./api/login', {
		method: 'POST',
		body: loginData
	})
	.then(res => res.json())
	.then(json => {
		console.log(json)

		if(json.loggedIn){
			form.reset()
			Promise.all([...form.elements].map(input => {
				input.classList.remove('filled')
			}))
			window.location = json.redirect
		}else{
			
		}

	})
	.catch(err => console.error(err))
}
