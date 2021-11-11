<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    new Vue({
        el: '#details',
        data: {
            details: [{
                date: null,
                benefiaciary: null,
                concept: null,
                kind: null,
                sub_details: [
                    {
                        activity: null,
                        class: null,
                        account: null,
                        amount: null
                    }
                ]
            }],
            kindOptions:  [
                {
                    id: 'ingreso',
                    'label': 'Ingreso'
                },
                {
                    id: 'egreso',
                    'label': 'Egreso'
                },
                {
                    id: 'comisionBancaria',
                    'label': 'Comision Banacaria'
                }
            ],
            options: [
                {
                    id: '001-CHF Fondo Mundial',
                    label: '001-CHF Fondo Mundial',
                    children: [
                        {
                            id: '1101-Efectivo Bancos',
                            label: '1101-Efectivo Bancos',
                        },
                        {
                            id: '1002-Cuentas X Cobrar',
                            label: '1002-Cuentas X Cobrar',
                        },
                        {
                            id: 'Otros Ingresos',
                            label: 'Otros Ingresos',
                        },
                        {
                            id: '5001-Prevencion-MTS Y Garifuna',
                            label: '5001-Prevencion-MTS Y Garifuna',
                            children: [
                                {
                                    id: '50101-Recursos Humanos',
                                    label: '50101-Recursos Humanos',
                                    children: [
                                        {
                                            id: '01-Salarios-Gestion Proyectos',
                                            label: '01-Salarios-Gestion Proyectos'
                                        },
                                        {
                                            id: '01-Salarios-Gestion Proyectos',
                                            label: '02-Salarios-Trabajadores'
                                        }
                                    ]
                                },
                            ]
                        }
                    ],
                },
                {
                    id: '015-Educarte',
                    label: '015-EducARTE',
                    children: [
                        {
                            id: '001-Ingresos',
                            label: '001-Ingresos',
                        },
                        {
                            id: '002-Egresos',
                            label: '002-Egresos',
                            children: [
                                {
                                    id: '1000-001 Recursos Humanos',
                                    label: '1000-001 Recursos Humanos',
                                },
                                {
                                    id: '1000-002 Costos Administrativos',
                                    label: '1000-002 Costos Administrativos',
                                },
                                {
                                    id: '1000-003 Programacion/Formacion',
                                    label: '1000-003 Programacion/Formacion',
                                },
                                {
                                    id: '1000-004 Material Promocional',
                                    label: '1000-004 Material Promocional',
                                },
                                {
                                    id: '1000-005  Consultoria',
                                    label: '1000-005 Consultoria',
                                },
                                {
                                    id: '1000-006 Mobiliario y Equipo',
                                    label: '1000-006 Mobiliario y Equipo',
                                },
                                {
                                    id: '1000-006 Movilizacion',
                                    label: '1000-006 Movilizacion',
                                }
                            ]
                        }
                    ],
                },
                {
                    id: '017-Investigacion Tabaquismo',
                    label: '017 Investigacion Tabaquismo',
                    children: [
                        {
                            id: '001 Ingresos',
                            label: '001 Ingresos',
                        },
                        {
                            id: '002 Egresos',
                            label: '002 Egresos',
                            children: [
                                {
                                    id: '3000-001 Recursos Humanos',
                                    label: '3000-001 Recursos Humanos',
                                },
                                {
                                    id: '3000-002 Costos Administrativos',
                                    label: '3000-002 Costos Administrativos',
                                },
                                {
                                    id: '3000-003 Programacion/Formacion',
                                    label: '3000-003 Programacion/Formacion',
                                },
                            ]
                        }
                    ],
                }
            ],
        },
        methods: {
            addDetail: function (event) {
                event.preventDefault();
                this.details.push({
                    date: null,
                    benefiaciary: '',
                    concept: '',
                    kind: '',
                    sub_details: [
                        {
                            activity: null,
                            class: null,
                            account: null,
                            amount: null
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