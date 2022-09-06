import { json } from '@sveltejs/kit'
import { PrismaClient } from '@prisma/client'
import type { Action } from './$types'

const prisma = new PrismaClient()

// /** @type {import('./$types').RequestHandler} */
// export function GET({ url }) {
// 	const min = Number(url.searchParams.get('min') ?? '0');

// /** @type {import('./$types').RequestHandler} */
// export const GET: Action = async ({ locals }) => {
// 	const response = await api('GET', `todos/${locals.userid}`);
// 	return await new Response(String(JSON.stringify(response.json())));
// };

// export async function GET({ request, url }) {
/** @type {import('./$types').RequestHandler} */
export const GET: Action = async ({ request, url }) => {
	const my_id: string = url.searchParams.get('id') ?? '0'
	let messages = await prisma.msg.findMany({
		distinct: ['senderId', 'receiverId'],
		where: {
			OR: [
				{
					senderId: my_id
				},
				{
					receiverId: my_id
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

	let distinct: number[] = []
	messages = messages.filter((msg: any) => {
		msg.youSent = msg.sender.id === my_id
		msg.otherUser = msg.youSent ? msg.receiver : msg.sender
		delete msg.sender
		delete msg.receiver
		if (distinct.indexOf(msg.otherUser.id) === -1) {
			distinct.push(msg.otherUser.id)
			return true
		}
		return false
	})

	return new Response(JSON.stringify(messages))
}
