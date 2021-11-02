<script>
    Vue.component('vue-multiselect', window.VueMultiselect.default);

    new Vue({
        el: '#details',
        data: {
            details: [{
                date: '',
                benefiaciary: '',
                concept: '',
                kind: '',
                sub_details: [
                    {
                        budget: '',
                        category: '',
                        sub_category: '',
                        amount: ''
                    }
                ]
            }],
            selected: 2,
            options: [
                {id: 1, text: 'Hello'},
                {id: 2, text: 'World'}
            ]
        },
        methods: {
            addDetail: function (event) {
                event.preventDefault();
                this.details.push({
                    date: '',
                    benefiaciary: '',
                    concept: '',
                    kind: '',
                    sub_details: [
                        {
                            budget: '',
                            category: '',
                            sub_category: '',
                            amount: ''
                        }
                    ]
                });
            },
            addNewSubCategory: function (index) {
                event.preventDefault();
                this.details[index].sub_details.push({
                    budget: '',
                    category: '',
                    sub_category: '',
                    amount: ''
                })
            },
            deleteSubItem: function (indexSubDetail, index) {
                event.preventDefault();
                this.details[index].sub_details.splice(indexSubDetail, 1);
            }
        }
    });
</script>