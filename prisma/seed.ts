import type { Prisma } from '@prisma/client'
import { prisma } from '$lib/utils/db'
import { hash } from '$lib/utils/encryption'

const currentTime = new Date().getTime(),
	generateTimestamp = (secondsOffset: number) => {
		return new Date(currentTime - secondsOffset * 1000).toISOString()
	}

let pushedUsers: Prisma.UserCreateInput[] = []
const userData = [
	{
		id: '1',
		role: 'USER',
		email: 'nosson_frankel@gmail.com',
		pswd: hash('Testing123!'),
		handle: 'nmfrankel',
		first: 'Nosson',
		last: 'Frankel',
		phone: '0534733971'
	},
	{
		id: undefined,
		role: 'USER',
		email: 'leue__@gmail.com',
		pswd: hash('S3curE!10'),
		handle: 'nm_frankel',
		first: 'Dev',
		last: 'Frankel',
		phone: '534733971'
	},
	{
		id: undefined,
		role: 'USER',
		email: 'nachibohen@gmail.com',
		pswd: 'must_reset',
		handle: 'DJ Nachman',
		first: 'Nachman',
		last: 'Tester',
		phone: '7189304820'
	},
	{
		id: undefined,
		role: 'USER',
		email: 'pmingber@gmail.com',
		pswd: 'must_reset',
		handle: 'PM Ingber',
		first: 'PM',
		last: 'Ingber',
		phone: '0533180351'
	},
	{
		id: undefined,
		role: 'USER',
		email: 'another_person@gmail.com',
		pswd: 'must_reset',
		handle: 'Another Person',
		first: 'Another',
		last: 'Person',
		phone: '7182534630'
	},
	{
		id: undefined,
		role: 'ADMIN',
		email: 'aharin26@gmail.com',
		pswd: 'must_reset',
		handle: 'AM Leonard',
		first: 'Aharon Meir',
		last: 'Leonard',
		phone: '3235615952'
	},
	{
		id: undefined,
		role: 'USER',
		email: 'ajlichtschein@gmail.com',
		pswd: 'must_reset',
		handle: 'AJ 23',
		first: 'AJ',
		last: 'Lichtshein',
		phone: '9179692634'
	}
]

async function main() {
	console.log(`Start seeding ...`)
	// Seed User table
	for (const u of userData) {
		const user: Prisma.UserCreateInput = await prisma.user.create({
			data: u
		})
		pushedUsers.push(user)
		console.log(`Created user with id: ${user.id}`)
	}

	const msgData: Prisma.MsgCreateInput[] = [
		{
			sender: {
				connect: {
					id: pushedUsers[2].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: "It's PM's bithrday 🙂🎉🎈🥳",
			posted: generateTimestamp(604700),
			metadata: 'modified,read|1|' + generateTimestamp(604630)
		},
		{
			sender: {
				connect: {
					id: pushedUsers[2].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: 'Please remind me tomorrow, I want to suprise him with a gift.',
			posted: '2022-08-05T09:27:00.441Z',
			metadata: 'modified'
		},
		{
			sender: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[3].id
				}
			},
			msgType: 'text/plain',
			content: 'Happy bithrday 🙂🎉🎈🥳',
			posted: generateTimestamp(604630),
			metadata: 'read|1|' + generateTimestamp(603630)
		},
		{
			sender: {
				connect: {
					id: pushedUsers[1].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: 'This is a test on the new type of id through cuid()',
			posted: generateTimestamp(60430),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[2].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: 'This is a test on the new type of id through cuid()',
			posted: generateTimestamp(50630),
			metadata: 'read|1|' + generateTimestamp(50430)
		},
		{
			sender: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[2].id
				}
			},
			msgType: 'text/plain',
			content: 'Doing great and thanks for asking.',
			posted: generateTimestamp(40430),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[5].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[6].id
				}
			},
			msgType: 'text/plain',
			content: 'This message should not show up',
			posted: generateTimestamp(40404),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[6].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[4].id
				}
			},
			msgType: 'text/plain',
			content: 'This message should also not show up',
			posted: generateTimestamp(4000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[5].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: "Here's the link for the new phone that I told you about...",
			posted: generateTimestamp(4000),
			metadata: 'read|1|' + generateTimestamp(3000)
		},
		{
			sender: {
				connect: {
					id: pushedUsers[3].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			msgType: 'text/plain',
			content: 'I forgot to remind you, seder will be regular time today.',
			posted: generateTimestamp(2000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[1].id
				}
			},
			msgType: 'text/plain',
			content: 'What time does shabbos start tomorrow night?',
			posted: generateTimestamp(1000),
			metadata: ''
		},
		{
			sender: {
				connect: {
					id: pushedUsers[0].id
				}
			},
			receiver: {
				connect: {
					id: pushedUsers[3].id
				}
			},
			msgType: 'text/plain',
			content: 'Hey what up, big boy?',
			posted: generateTimestamp(0),
			metadata: ''
		}
	]

	// Seed Msg table
	for (const m of msgData) {
		const msg = await prisma.msg.create({
			data: m
		})
		console.log(`Created message with id: ${msg.id}`)
	}
	console.log(`Seeding finished.`)
}

main()
	.then(async () => {
		await prisma.$disconnect()
	})
	.catch(async (e) => {
		console.error(e)
		await prisma.$disconnect()
		process.exit(1)
	})
