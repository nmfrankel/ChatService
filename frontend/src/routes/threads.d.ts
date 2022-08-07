interface User {
	id: number
	email: string
	handle: string
	first: string
	last: string
	phone: string
}

interface Thread {
	id: string
	otherUser: User
	msgType: string
	content: string
	posted: string
	metadata: string
	youSent: boolean
}