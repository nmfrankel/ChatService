interface User {
	id: string
	email: string
	handle: string | null
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
