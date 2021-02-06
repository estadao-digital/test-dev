import mongoose from 'mongoose'





const MarcaSchema = new mongoose.Schema({
  marca: { type: String, required: true },
  createdAt: { type: Date, default: Date.now }

})


export default mongoose.model('Marca', MarcaSchema);