<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="<?=base_url();?>assets/kendo.common.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/kendo.default.min.css" />

    <script src="<?=base_url();?>assets/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/kendo.all.min.js"></script>
</head>
<body>
<div id="example">
    <div id="grid"></div>

    <script>
        $(document).ready(function () {
            var crudServiceBaseUrl = "<?php echo base_url(); ?>",
                dataSource = new kendo.data.DataSource({
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl + "welcome/get_data",
                            dataType: "json"
                        },
                        update: {
                            url: crudServiceBaseUrl + "/Products/Update",
                            dataType: "json"
                        },
                        destroy: {
                            url: crudServiceBaseUrl + "/Products/Destroy",
                            dataType: "jsonp"
                        },
                        create: {
                            url: crudServiceBaseUrl + "/Products/Create",
                            dataType: "jsonp"
                        },
                        parameterMap: function(options, operation) {
                            if (operation !== "read" && options.models) {
                                return {models: kendo.stringify(options.models)};
                            }
                        }
                    },
                    batch: true,
                    pageSize: 20,
                    schema: {
                        model: {
                            id: "itemID",
                            fields: {
                                itemID: { editable: false, nullable: true },
                                ITEM: { validation: { required: true } },
                                PurchaseRate: { validation: { required: true } },
                                SIZE: { validation: { required: true } },
                                FLAG: { validation: { required: true } }



                            }
                        }
                    }
                });

            $("#grid").kendoGrid({
                dataSource: dataSource,
                pageable: true,
                height: 550,
                toolbar: ["create"],
                columns: [
                    { field:"ITEM", title: "Product Name",width: "120px" },
                    { field: "PurchaseRate", title:"Unit Price", format: "{0:c}", width: "120px" },
                    { field: "SIZE", title:"Size", width: "120px" },
                    { field: "FLAG", title:"Flag", width: "120px" },
                    { command: ["edit", "destroy"], title: "&nbsp;", width: "200px" }],
                editable: "popup"
            });
        });
    </script>
</div>


</body>
</html>