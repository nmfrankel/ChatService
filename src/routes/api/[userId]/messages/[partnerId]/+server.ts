import { json, error, redirect } from '@sveltejs/kit'
import type { RequestHandler } from './$types'
import { prisma } from '$lib/utils/db.server'
import { pusher } from '$lib/utils/pusher.server'

// GET:    loads messages between current [user] and [partner]'s id
export const GET: RequestHandler = async ({ locals, params }) => {
	const { user } = locals

	if (!user || user.sub !== params.userId) {
		throw redirect(302, '/login')
	}

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
					sub: true,
					email: true,
					handle: true,
					given_name: true,
					family_name: true,
					phone: true
				}
			},
			receiver: {
				select: {
					sub: true,
					email: true,
					handle: true,
					given_name: true,
					family_name: true,
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
	// if (messages[0] /* && messages[0].id !== userId */ && !messages[0].metadata.match('read')) {
	// 	await prisma.$transaction(
	// 		messages.map((msg) =>
	// 			prisma.msg.update({
	// 				data: {
	// 					metadata: {
	// 						set: msg.metadata.length
	// 							? `${msg.metadata},read|${userId}|${new Date().toISOString()}`
	// 							: `read|${userId}|${new Date().toISOString()}`
	// 					}
	// 				},
	// 				where: { id: msg.id }
	// 			})
	// 		)
	// 	)
	// }
	if (messages[0] /* && messages[0].id !== userId */ && !messages[0].metadata.match('read')) {
		// 		import { User } from "prisma"
		// declare module "prisma" {
		//   interface User {
		//     computeFullName(): string
		//   }
		// }
		// User.prototype.computeFullName = function () {
		//   return this.user.firstName + ' ' + this.user.lastName,
		// };

		// async function main() {
		//   const user = await prisma.user.findUnique({ where: 1 })
		//   user.computeFullName() // This now works, because we extended `User`
		//   user.firstName // Still works
		// }

		prisma.msg.updateMany({
			where: {
				receiverId: {
					not: userId
				}
			},
			data: {}
		})

		// await prisma.$transaction(
		// 	messages.map((msg) =>
		// 		prisma.msg.update({
		// 			data: {
		// 				metadata: {
		// 					set: msg.metadata.length
		// 						? `${msg.metadata},read|${my_id}|${new Date().toISOString()}`
		// 						: `read|${my_id}|${new Date().toISOString()}`
		// 				}
		// 			},
		// 			where: { id: msg.id }
		// 		})
		// 	)
		// )
	}

	return json(messages)
}

// POST:   Send a message from current [user] to [partner]'s id
export const POST: RequestHandler = async ({ request, locals, params }) => {
	const { user } = locals

	if (!user || user.sub !== params.userId) {
		throw redirect(302, '/login')
	}

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
					sub: true,
					handle: true,
					given_name: true,
					family_name: true
				}
			},
			receiver: {
				select: {
					sub: true,
					handle: true,
					given_name: true,
					family_name: true
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
	// await pusher.sendToUser("user-id", "msg", result)

	await pusher.trigger(`private-chat-${partnerId}`, 'msg', result)

	return json(result)
}

// PATCH: ...
// DELETE: ...
