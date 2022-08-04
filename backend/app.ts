import express from 'express'
import 'dotenv/config'
import cookieParser from 'cookie-parser'
import cors from 'cors'

const app = express()

// Read req body as JSON
app.use(express.json())

// enable reading cookies
app.use(cookieParser())

// enable CORS from *
app.use(cors())

// serve static sample data
app.use(express.static("sample"))

// Routes
app.use('/access_control', require('./routes/access_control'))

app.use('/users', require('./routes/users'))

app.use('/message', require('./routes/message'))

const PORT = Number(process.env.PORT) || 3000
app.listen(PORT, () => console.log(`Server is listening on port ${PORT}`))