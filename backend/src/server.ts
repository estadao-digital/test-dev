import express from 'express'
import cors from 'cors'
import dotenv from 'dotenv'
import routes from './routes'
dotenv.config()


import mongoose from 'mongoose'

const mongourl = process.env.mongourl

mongoose.connect(`${mongourl}`, {
  useNewUrlParser: true,
  useUnifiedTopology: true,
  useFindAndModify: false,
  useCreateIndex: true
})


const app = express();

app.use(cors());

app.use(express.json())

app.use(routes)

app.listen(process.env.port)




