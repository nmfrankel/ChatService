import storage from '$lib/utils/store'

let otherUser: User = {
	id: '',
	first: 'Unknown',
	last: 'conversation',
	phone: '',
	email: '',
	handle: 'missing'
}

interface Users {
	otherUser: User
}

export const userState = storage<Users>('userData', {
	otherUser
})
