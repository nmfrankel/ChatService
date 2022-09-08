import { json } from '@sveltejs/kit'
import { PrismaClient } from '@prisma/client'
import type { Action } from './$types'

const prisma = new PrismaClient()

// export async function GET({ request, url }) {
export const GET: Action = async ({ request, url, params }) => {
	const body = await request.text() // .json()
	// console.log(
	// 	'url.searchParams: ' + url.searchParams + ' params: ' + JSON.stringify(params),
	// 	' body: ' + JSON.stringify(body)
	// )

	const id: string = params.user_id || '',
		my_id: string = url.searchParams.get('my_id')

	const messages = await prisma.msg.findMany({
		where: {
			OR: [
				{
					senderId: my_id,
					receiverId: id
				},
				{
					senderId: id,
					receiverId: my_id
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

export const POST: Action = async ({ request, params }) => {
	const senderId: string = params.user_id,
		{
			receiverId,
			msgType,
			content,
			posted,
			metadata
		}: { receiverId: string; msgType: string; content: string; posted: string; metadata: string } =
			await request.json()

	// console.log(senderId, receiverId)

	const result = await prisma.msg.create({
		data: {
			senderId,
			receiverId,
			msgType: msgType ?? 'text/plain',
			content,
			// posted,
			metadata: metadata ?? ''
		}
	})
	return json(result)
}
