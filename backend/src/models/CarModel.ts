import mongoose from 'mongoose'





const CarSchema = new mongoose.Schema({
  marca: { type: String, required: true },
  modelo: { type: String, required: true },
  ano: { type: String, required: true },
  createdAt: { type: Date, default: Date.now }

})


export default mongoose.model('Car', CarSchema);