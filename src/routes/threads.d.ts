interface Thread {
	id: string
	partner: UserToken
	msgType: string
	content: string
	posted: string
	metadata: string
	outgoing: boolean
	isRead: boolean
}
