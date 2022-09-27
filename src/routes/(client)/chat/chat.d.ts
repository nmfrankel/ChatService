interface Msg {
	id: string
	msgType: string
	content: string
	posted: string
	metadata: string
	sender: {
		sub: string
		email: string
		handle: string | null
		given_name: string
		family_name: string
		phone: string
	}
	receiver: {
		sub: string
		email: string
		handle: string | null
		given_name: string
		family_name: string
		phone: string
	}
}
