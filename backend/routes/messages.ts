import { Router, Request, Response } from 'express'
import { Prisma, PrismaClient } from '@prisma/client'

const router = Router()
const prisma = new PrismaClient()

router.get('/', async (req: Request, res: Response) => {
	const my_id: number = 1
	let messages = await prisma.msg.findMany({
		distinct: ['senderId', 'receiverId'],
		where: {
			OR: [
				{
					senderId: my_id,
				},
				{
					receiverId: my_id
				},
			]
		},
		orderBy: {
			posted: 'desc',
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
		msg.youSent = msg.sender.id===my_id
		msg.otherUser = msg.youSent? msg.receiver: msg.sender
		delete msg.sender
		delete msg.receiver
		if(distinct.indexOf(msg.otherUser.id)===-1){
			distinct.push(msg.otherUser.id)
			return true
		}
		return false
	})

	res.json(messages)
})


router.get("/:id", async (req, res) => {
	const id: number = Number(req.params.id) || 0,
	my_id: number = 1

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
				},
			]
		},
		// skip: 0,
		// take: 20,
		orderBy: {
			posted: 'desc',
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
	if(messages[0] && !messages[0].metadata.match('read')){
		await prisma.$transaction(
			messages.map(msg => prisma.msg.update({
				data: {
					metadata: {
					set: msg.metadata.length?
						`${msg.metadata},read|${my_id}|${new Date().toISOString()}`:
						`read|${my_id}|${new Date().toISOString()}`,
					},
				},
				where: { id: msg.id },
			}))
		)
	}

	res.json(messages)
})

router.post("/:id", async (req, res) => {
	const id: number = Number(req.params.id) || 0,
	my_id: number = 1,
	{ msgType, content, posted, metadata }: 
	{ msgType: string, content: string, posted: string, metadata: string } = req.body

	const result = await prisma.msg.create({
		data: {
			senderId: my_id,
			receiverId: Number(id),
			msgType: msgType ?? "text/plain",
			content,
			// posted,
			metadata: metadata ?? ""
		}
	})
	return res.status(201).json(result)
})

router.delete("/:id", async (req, res) => {
	// check for admin rights on account changing
	// check for admin rights on account changing

	const id = req.params.id

	const deleteMsg = await prisma.msg.delete({
		where: {
			id
		}
	})
	res.json(deleteMsg)
})

module.exports = router