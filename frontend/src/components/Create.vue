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
                    this.$store.dispatch('newCar', this.form).then(() => {
                        this.$router.push('/')
                    })
                }
            });
        }
    },
    computed: {
        brands () {
            return this.$store.state.brands.brandsList
        }
    },
    created () {
        this.$store.dispatch('getBrands')
    }
}
</script>