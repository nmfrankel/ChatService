interface thread {
	id: string
	sender: {
		id: number
		email: string
		handle: string
		first: string
		last: string
		phone: string
	}
	receiver: {
		id: number
		email: string
		handle: string
		first: string
		last: string
		phone: string
	}
	msgType: string
	content: string
	posted: string
	metadata: string
}