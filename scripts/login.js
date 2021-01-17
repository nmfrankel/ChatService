let form = document.getElementsByTagName('form')[0]


async function login(e){
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

	})
	.catch(err => console.error(err))
}