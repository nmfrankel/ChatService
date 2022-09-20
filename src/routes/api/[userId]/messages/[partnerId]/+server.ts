import { json, error } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/utils/db'
import { pusher } from '$lib/utils/pusher'

// GET:    loads messages between current [user] and [partner]'s id
export const GET: RequestHandler = async ({ locals, params }) => {
	// SECURITY CHECK: confirm user has access
	// SECURITY CHECK: confirm user has access
	// read locals.userid cookie to confirm user, use JWT or encrypted data for cookie

	const userId = params.userId,
		partnerId = params.partnerId

	const messages = await prisma.msg.findMany({
		where: {
			OR: [
				{
					senderId: userId,
					receiverId: partnerId
				},
				{
					senderId: partnerId,
					receiverId: userId
				}
			]
		},
		// skip: 0,
		// take: 20,
		orderBy: {
			posted: 'desc'
		},
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

	// mark messages as read
	// if (messages[0] /* && messages[0].id !== my_id */ && !messages[0].metadata.match('read')) {
	// 	await prisma.$transaction(
	// 		messages.map((msg) =>
	// 			prisma.msg.update({
	// 				data: {
	// 					metadata: {
	// 						set: msg.metadata.length
	// 							? `${msg.metadata},read|${my_id}|${new Date().toISOString()}`
	// 							: `read|${my_id}|${new Date().toISOString()}`
	// 					}
	// 				},
	// 				where: { id: msg.id }
	// 			})
	// 		)
	// 	)
	// }

	return json(messages)
}

// POST:   Send a message from current [user] to [partner]'s id
export const POST: RequestHandler = async ({ request, locals, params }) => {
	// SECURITY CHECK: confirm user has access
	// SECURITY CHECK: confirm user has access
	// read locals.userid cookie to confirm user, use JWT or encrypted data for cookie

	const userId = params.userId,
		partnerId = params.partnerId,
		{ msgType, content, posted, metadata } = await request.json()

	if (!content) throw error(400, 'You cannot send an empty message.')

	const result = await prisma.msg.create({
		data: {
			senderId: userId,
			receiverId: partnerId,
			msgType: msgType ?? 'text/plain',
			content,
			metadata: metadata ?? ''
		},
		select: {
			id: true,
			sender: {
				select: {
					id: true,
					handle: true,
					first: true,
					last: true
				}
			},
			receiver: {
				select: {
					id: true,
					handle: true,
					first: true,
					last: true
				}
			},
			msgType: true,
			content: true,
			posted: true,
			metadata: true
		}
	})

	// broadcast new message to partnerId
	// CHECK IF partnerId IS ONLINE, to save on broadcast quota
	// CHECK IF partnerId IS ONLINE, to save on broadcast quota
	// CHECK IF partnerId IS ONLINE, to save on broadcast quota
	await pusher.trigger(`private-chat-${partnerId}`, 'msg', result)

	return json(result)
}

// PATCH: ...
// DELETE: ...
