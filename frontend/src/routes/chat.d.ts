interface Msg {
	id: string
	msgType: string
	content: string
	posted: Date
	metadata: string
	sender: {
		id: string
		email: string
		handle: string | null
		first: string
		last: string
		phone: string
	}
	receiver: {
		id: string
		email: string
		handle: string | null
		first: string
		last: string
		phone: string
	}
}