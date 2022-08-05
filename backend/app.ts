import express from 'express'
import 'dotenv/config'
// import cookieParser from 'cookie-parser'
const cookieParser = require('cookie-parser')
import cors from 'cors'

const app = express()

// serve static sample data
app.use(express.static("sample"))

// enable reading cookies
app.use(cookieParser())

//Security
app.use(require("./middleware/security"))

// Read req body as JSON
app.use(express.json())

// enable CORS from *
app.use(cors())

// Routes
app.use('/access_control', require('./routes/access_control'))

app.use('/users', require('./routes/users'))

app.use('/messages', require('./routes/messages'))

// 404 handler
app.use((req, res, next) => res.status(404).json({ message: req.url + ' is not a valid endpoint' }))

const PORT = Number(process.env.PORT) || 3000
app.listen(PORT, () => console.log(`Server is listening on port ${PORT}`))