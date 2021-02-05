<template>
  <b-container>

    <b-form>
    <b-row class="mb-2">
      <b-col col lg="12" sm="12" md="12">
        <b-form-group label="Marca">
          <b-form-select
            :state="$v.car.brand_id.required"
            v-model="$v.car.brand_id.$model"
            :options="brands"
          ></b-form-select>
        </b-form-group>
      </b-col>
      <b-col col lg="12" sm="12" md="12">
        <b-form-group label="Modelo">
          <b-form-input
            v-model="$v.car.model.$model"
            :state="!$v.car.model.$error"
          />
        </b-form-group>
      </b-col>
      <b-col col lg="6" sm="12" md="12">
        <b-form-group label="Ano">
          <b-form-input
            v-model="$v.car.year.$model"
            :state="!$v.car.year.$error"
          />
        </b-form-group>
      </b-col>
       <b-col col lg="6" sm="12" md="6">
        <b-form-group label="Valor">
          <b-form-input
            v-model="$v.car.amount.$model"
            :state="!$v.car.amount.$error"
          />
        </b-form-group>
      </b-col>
      <b-col col lg="12" sm="12" md="12">
        <b-form-group label="Descrição">
          <b-form-textarea
            rows="3"
            max-rows="6"
            v-model="$v.car.description.$model"
            :state="$v.car.description.required"
          />
        </b-form-group>
      </b-col>
    </b-row>
    <b-row class="mb-2">
      <b-col col lg="12">
        <b-form-group label="Imagem/Foto" label-for="image">
          <b-form-file
            v-model="file"
            placeholder="Envie uma foto do carro"
            browse-text="Enviar foto"
          >
          </b-form-file
          ><span class="alert alert-danger mt-2" v-if="erroFoto"
            >O arquivo escolhido não será enviado. Escolha uma imagem válida.</span
          >
        </b-form-group>
      </b-col>
      <div id="preview" class="text-center pb-4">
        <img style="max-width: 80%" v-if="url" :src="url" />
      </div>
    </b-row>
    <div class="row m-0 p-0 text-right">
      <div class="col m-0 p-0">
        <b-button
          class="mr-3"
          type="reset"
          variant="danger"
          @click="$router.go(-1)"
          ><b-icon icon="x" aria-hidden="true"></b-icon> Cancelar</b-button
        >
        <b-button @click="salvar" :disabled="$v.$invalid"  variant="success"
          ><b-icon icon="check" aria-hidden="true"></b-icon> Salvar</b-button
        >
      </div>
    </div>
  </b-form>
  </b-container>
</template>
<script>
import axios from '@/config/axios'
import { required, between, minLength, maxLength, helpers } from 'vuelidate/lib/validators'
import { mapActions } from 'vuex'
const amount = helpers.regex('decimal', /^[-]?\d*(\.\d+)?$/)
export default {
  name: 'CarForm',
  data () {
    return {
      id: null,
      url: null,
      erroFoto: false,
      file: null,
      car: {
        year: '',
        model: '',
        description: '',
        amount: '',
        brand_id: ''
      },
      brands: []
    }
  },
  validations: {
    car: {
      year: { required, minLength: minLength(4), between: between(1900, 2022) },
      model: { required, maxLength: maxLength(14) },
      description: { required },
      amount: { required, amount, maxLength: maxLength(8) },
      brand_id: { required }
    }
  },
  watch: {
    file: function () {
      this.confere()
    }
  },
  created () {
    this.readBrands()
    if (this.$route.params.id > 0) {
      this.setTitle({ title: 'Dashboard / Editar Carro' })
      this.id = this.$route.params.id
      this.readCar()
    } else {
      this.setTitle({
        title: 'Dashboard / Cadastrar novo Carro'
      })
    }
  },
  methods: {
    ...mapActions(['setLoad', 'setTitle', 'setToast']),
    async readBrands () {
      try {
        this.setLoad({ load: true })

        await axios
          .get('brands/')
          .then((resp) => {
            this.brands = resp.data.data.map((i) => {
              return { value: i.id, text: i.name }
            })
          })
      } catch (e) {
        console.log(e)
        this.setToast({
          toast: {
            show: true,
            variant: 'danger',
            message: 'Erro ao buscar Carros.',
            title: 'Erro!'
          }
        })
      } finally {
        this.setLoad({ load: false })
      }
    },
    async readCar () {
      try {
        this.setLoad({ load: true })

        await axios
          .get('cars/' + this.id)
          .then((resp) => {
            this.car = resp.data.data
          })
      } catch (e) {
        console.log(e)
        this.setToast({
          toast: {
            show: true,
            variant: 'danger',
            message: 'Erro ao buscar Carros.',
            title: 'Erro!'
          }
        })
      } finally {
        this.setLoad({ load: false })
      }
    },
    async salvar () {
      try {
        this.setLoad({ load: true })
        if (this.id > 0) {
          await axios
            .put('cars/' + this.id, this.car)
            .then((resp) => {
              resp = resp.data
              if (this.file && this.erroFoto === false && resp.data.id > 0) this.upload(resp.data.id)
              else this.$router.push('/app/car')
            })
          this.setToast({
            toast: {
              show: true,
              variant: 'success',
              message: 'Carro atualizado com sucesso.',
              title: 'Sucesso!'
            }
          })
        } else {
          await axios
            .post('cars/', this.car)
            .then((resp) => {
              resp = resp.data
              if (this.file && this.erroFoto === false && resp.data.id > 0) this.upload(resp.data.id)
              else this.$router.push('/app/car')
            })
          this.setToast({
            toast: {
              show: true,
              variant: 'success',
              message: 'Carro Cadastrado com sucesso.',
              title: 'Sucesso!'
            }
          })
        }
      } catch (e) {
        console.log(e)
        this.setToast({
          toast: {
            show: true,
            variant: 'danger',
            message: 'Erro ao efetuar operação.',
            title: 'Erro!'
          }
        })
      } finally {
        this.setLoad({ load: false })
      }
    },
    async upload (id) {
      if (this.file) {
        if (this.file.type.indexOf('image') !== -1) {
          const headerFile = { headers: { 'Content-Type': 'multipart/form-data' } }
          const formData = new FormData()
          formData.append('file', this.file)
          await axios
            .post('upload/car/' + id,
              formData,
              headerFile
            )
            .then((resp) => {
              // upload ok entao enviar para api alvara denunciaArquivo
              console.log(resp)
              this.$router.push('/app/car')
            })
            .catch((e) => {
              console.log(e)
              this.responseFile = false
              this.setToast({
                toast: {
                  show: true,
                  variant: 'danger',
                  message: 'Ocorreu um erro e não foi possivel enviar a imagem/foto.',
                  title: 'Erro ao Salvar!'
                }
              })
            })
        } else {
          // console.log("nao pode enviar");
        }
      }
    },
    confere () {
      if (this.file) {
        console.log(this.file)
        if (this.file.type.indexOf('image') !== -1) {
          this.erroFoto = false
          this.url = URL.createObjectURL(this.file)
        } else {
          this.erroFoto = true
          this.file = null
        }
      } else {
        this.url = null
      }
      // console.log(this.file);
    }

  }
}
</script>
