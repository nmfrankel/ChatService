import { json, error } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/db'

// GET:    loads distinct messages (threads) between current [user] and [partner]'s id
export const GET: RequestHandler = async ({ locals, params }) => {
	// SECURITY CHECK: confirm user has access
	// SECURITY CHECK: confirm user has access
	// read locals.userid cookie to confirm user, use JWT or encrypted data for cookie

	const userId = params.userId

	let messages = await prisma.msg.findMany({
		distinct: ['senderId', 'receiverId'],
		where: {
			OR: [
				{
					senderId: userId
				},
				{
					receiverId: userId
				}
			]
		},
		orderBy: {
			posted: 'desc'
		},
		// include:{
		// 	_count: {
		// 		select:{ id: my_id }
		// 	}
		// },
		select: {
			id: true,
			sender: {
				select: {
					id: true,
					email: true,
					handle: true,
					first: true,
					last: true,
					phone: true
				}
			},
			receiver: {
				select: {
					id: true,
					email: true,
					handle: true,
					first: true,
					last: true,
					phone: true
				}
			},
			msgType: true,
			content: true,
			posted: true,
			metadata: true
		}
	})

	let distinct: string[] = []
	messages = messages.filter((msg: any) => {
		msg.youSent = msg.sender.id === userId
		msg.otherUser = msg.youSent ? msg.receiver : msg.sender
		delete msg.sender
		delete msg.receiver

		// escape if already in new messages list
		if (distinct.indexOf(msg.otherUser.id) >= 0) return false

		distinct.push(msg.otherUser.id)
		return true
	})

	return json(messages)
}

// PATCH:  Gives the option to archive a thread
export const PATCH: RequestHandler = async ({ request, locals, params }) => {
	throw error(400, 'An error occured while processing your request.')
}

// DELETE: Delete's a thread on the [user]'s side
export const DELETE: RequestHandler = async ({ request, locals, params }) => {
	throw error(400, 'An error occured while processing your request.')
}
