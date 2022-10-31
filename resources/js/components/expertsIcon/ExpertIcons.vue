<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="card expertIconContainer">
                <div class="card-header"><h5 class="card-title">Expert Icons
                </h5></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Upload Icon</th>
                            <th>Tooltip Text</th>
                            <!--<th>Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="(icon, index) in form.icons" :key="index">
                                <td>
                                    <div class="m-0 form-group">
                                        <!-- <input v-model="form.icons[index].index" placeholder="Index" disabled="" type="text" class="form-control"> -->
<!--                                        
                                        <label for="photo">{{ trans('cruds.product.fields.photo') }}</label> -->
                                        <div class="needsclick dropzone expertIconsImg" ></div>
                                        
                                        <span class="help-block"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="m-0 form-group">
                                        <input v-model="form.icons[index].tooltip" placeholder="Tooltip Text" name="tooltip[]" type="text" class=" form-control">
                                    </div>
                                </td>
                               
                                <!--<td>
                                    <div class="m-0 form-group">
                                        <button @click="removeIcon(index)" type="button" class="mb-0 btn btn-outline-danger"><i class="fas fa-minus mx-1"></i></button>
                                    </div>
                                </td>-->
                            </tr>
                        </tbody>
                        <!--<tfoot>
                        <tr>
                            <td colspan="5">
                                <button type="button" class="mb-0 btn btn-outline-success" @click="addMoreIcon"><i class="fas fa-plus mx-1"></i> Add more Icon</button>
                            </td>
                        </tr>
                        </tfoot>-->
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["expertIcon"],
        data() {
            return {
                form: {
                    icons: [
                        {
                            index: 1,
                            img: '',
                            tooltip: ''
                        },
                        {
                            index: 2,
                            img: '',
                            tooltip: ''
                        },
                        {
                            index: 3,
                            img: '',
                            tooltip: ''
                        },
                        {
                            index: 4,
                            img: '',
                            tooltip: ''
                        },
                        {
                            index: 5,
                            img: '',
                            tooltip: ''
                        },
                        {
                            index: 6,
                            img: '',
                            tooltip: ''
                        },
                    ]
                }
            }
        },
        mounted() {
            if(this.expertIcon && this.expertIcon.length > 0){
                let allIcons = JSON.parse(this.expertIcon);
                allIcons.map( (icon, index) => {
                    console.log(icon)
                    this.form.icons[index].tooltip = icon.tooltip
                })
            }
        },
        methods: {
            addMoreIcon() {
                this.form.icons.push({
                    index: this.form.icons.length + 1,
                    img: '#',
                    tooltip: ''
                });
            },
            removeIcon(iconIndex) {
                this.form.icons.splice(iconIndex, 1)
                let icons = [];
                this.form.icons.map( (icon, index) => {
                    icon.index = index + 1
                    icons.push(icon);
                })
                this.form.icons = icons;
            },
        }
    }
</script>
