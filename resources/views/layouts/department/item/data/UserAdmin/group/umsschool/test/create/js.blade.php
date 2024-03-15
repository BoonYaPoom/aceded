    <script>
        $(document).ready(function() {
            var sch2Div = $('#sch2');
            var extender2 = {!! $extender2 !!};
            var extender_id2 = $('#extender_id2');
            var sch3Div = $('#sch3');
            var extender3 = {!! $extender3 !!};
            var extender_id3 = $('#extender_id3');

            var extender4 = {!! $extender4 !!};
            var provin = $('#provin');
            var distrit = $('#distrits');
            var subdistrits = $('#subdistrits');
            var distritdata = {!! $districts !!};
            var subdistritsdata = {!! $subdistricts !!};
            $('#extender_id').select2();
            provin.select2();


            $('#provin').on('change', function() {
                var selectedprovinId = $(this).val();
                var foundMatchprovin = false;
                distrit.select2();
                distrit.empty();
                distrit.append('<option value="" selected disabled>-- เลือกอำเภอ --</option>');
                console.log(selectedprovinId)
                $.each(distritdata, function(index, dis) {
                    if (dis.province_id == selectedprovinId) {
                        distrit.append($('<option></option>')
                            .attr('value', dis.id)
                            .text(dis.name_in_thai));
                        foundMatchprovin = true;
                        $('#distri').show();
                    }
                });

            });

            $('#distrits').on('change', function() {
                var selecteddistritId = $(this).val();
                var foundMatchdistrit = false;
                subdistrits.select2();
                subdistrits.empty();
                subdistrits.append('<option value="" selected disabled>-- เลือกตำบล --</option>');
                console.log(selecteddistritId)
                $.each(subdistritsdata, function(index, subdis) {
                    if (subdis.district_id == selecteddistritId) {
                        subdistrits.append($('<option></option>')
                            .attr('value', subdis.id)
                            .text(subdis.name_in_thai));
                        foundMatchdistrit = true;
                        $('#subdis').show();
                    }
                });

            });


            $('#extender_id').on('change', function() {
                var selectedExtenderId = $(this).val();
                var foundMatch = false;
                extender_id2.select2();
                extender_id2.empty();
                extender_id2.append('<option value="" selected disabled>-- เลือกสังกัด --</option>');

                $.each(extender2, function(index, ext2) {
                    if (ext2.item_parent_id == selectedExtenderId) {
                        var matchingExtender3 = extender3.filter(function(ext3) {
                            return ext2.extender_id == ext3.item_parent_id;
                        });
                        countMatchingExtender3 = matchingExtender3.length;

                        // ทำอื่นตามต้องการ
                        if (countMatchingExtender3 == 0) {
                            foundMatch = true;
                            $('#textsch2').show();
                            sch2Div.hide();
                            sch3Div.hide();
                            $('#textsch3').hide();
                            $('#textsch4').hide();
                            $('#school_div').show();

                        } else {
                            extender_id2.append($('<option></option>')
                                .attr('value', ext2.extender_id)
                                .text(ext2.name));
                            foundMatch = true;
                            sch2Div.show();
                            $('#textsch2').hide();
                            sch3Div.hide();
                            $('#textsch3').hide();
                            $('#textsch4').hide();
                            $('#school_div').hide();
                        }
                    }


                });

            });

            $('#extender_id2').on('change', function() {
                var selectedExtenderId = $(this).val();
                var foundMatch2 = false;
                extender_id3.select2();
                extender_id3.empty();
                extender_id3.append(
                    '<option value="" selected disabled>-- เลือกสังกัด --</option>'
                );
                $.each(extender3, function(index, ext3) {
                    if (ext3.item_parent_id == selectedExtenderId) {
                        var matchingExtender4 = extender4.filter(function(ext4) {
                            return ext3.extender_id == ext4.item_parent_id;
                        });
                        countMatchingExtender4 = matchingExtender4.length;
                        if (countMatchingExtender4 == 0) {
                            $('#textsch3').show();
                            $('#textsch4').hide();

                            sch3Div.hide();
                            $('#school_div').show();

                        } else {
                            extender_id3.append($('<option></option>')
                                .attr('value', ext3.extender_id)
                                .text(ext3.name));
                            foundMatch2 = true;
                            sch3Div.show();
                            $('#textsch3').hide();
                            $('#textsch4').hide();
                            $('#school_div').hide();
                        }
                    }


                });
            });

            $('#extender_id3').on('change', function() {
                var selectedExtenderId = $(this).val();
                if (selectedExtenderId) {
                    $('#textsch4').show();
                }
            });

        });
    </script>
