<script>
export default {
    data () {        
        return {
            form: {
                brand_id: '',
                model: '',
                year: ''                
            }
        }
    },
    template: require('./form.html'),
    methods: {
        validateBeforeSubmit() {
            this.$validator.validateAll().then((result) => {
                if (result) {                    
                    this.$store.dispatch('updateCar', this.form).then(() => {
                        this.$router.push('/')
                    })
                }
            });
        }
    },
    computed: {
        cars () {
            return this.$store.state.cars.carsView
        },
        brands () {
            return this.$store.state.brands.brandsList
        }
    },
    created () {
        this.$store.dispatch('getCar', this.$route.params.id)
    }
}
</script>