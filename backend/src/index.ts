import { Prisma, PrismaClient } from '@prisma/client'
import express from 'express'
import 'dotenv/config'

const port = Number(process.env.PORT) || 3000
const prisma = new PrismaClient()
const app = express()

app.use(express.json())

// insert routing logic
// insert routing logic
// insert routing logic

app.listen(port, () => console.log(`Sever is listening on port ${port}`))