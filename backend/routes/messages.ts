import { Router, Request, Response } from 'express'
import { Prisma, PrismaClient } from '@prisma/client'

const router = Router()
const prisma = new PrismaClient()

router.get('/', async (req: Request, res: Response) => {
	const my_id: number = 1
	const messages = await prisma.msg.findMany({
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
		select: {
			id: true,
			sender: {
				select: {
					email: true,
					handle: true,
					first: true,
					last: true,
					phone: true
				}
			},
			receiver: {
				select: {
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

	// mark last message as read
	if(!messages[0].metadata.match('read')){
		await prisma.msg.update({
			data: {
			  	metadata: {
					set: messages[0].metadata.length?
						`${messages[0].metadata},read|${my_id}|${new Date().toISOString()}`:
						`read|${my_id}|${new Date().toISOString()}`,
			  },
			},
			where: { id: messages[0].id },
		})
	}

	res.json(messages)

	// await prisma.msg.updateMany({
	// 	where: {
	// 		OR: [
	// 			{
	// 				senderId: my_id,
	// 				receiverId: id
	// 			},
	// 			{
	// 				senderId: id,
	// 				receiverId: my_id
	// 			}
	// 		],
	// 		NOT: {
	// 			metadata: {
	// 				contains: 'read',
	// 			},
	// 		},
	// 	},
	// 	data: {
	// 		metadata: '',
	// 	},
	// 	take: 1,
	// 	orderBy: {
	// 		posted: 'desc',
	// 	}
	// })
})

router.post("/", async (req, res) => {
	const { senderId, receiverId, msgType, content, posted, metadata }: 
	{ senderId: string, receiverId: string, msgType: string, content: string, posted: string, metadata: string } = req.body

	const result = await prisma.msg.create({
		data: {
			senderId: Number(senderId),
			receiverId: Number(receiverId),
			msgType: msgType ?? "text/plain",
			content,
			posted,
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