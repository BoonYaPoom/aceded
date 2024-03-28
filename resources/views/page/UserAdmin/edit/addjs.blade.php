  <script>
      $(document).ready(function() {
          var sch1Div = $('#sch1');
          var extender1 = {!! $extender1 !!};
          var extender_id1 = $('#extender_id');

          var sch2Div = $('#sch2');
          var extender2 = {!! $extender2 !!};
          var extender_id2 = $('#extender_id2');

          var sch3Div = $('#sch3');
          var extender3 = {!! $extender3 !!};
          var extender_id3 = $('#extender_id3');

          var sch4Div = $('#sch4');
          var extender_id4 = $('#extender_id4');
          var extender4 = {!! $extender4 !!};

          var sch5Div = $('#sch5');
          var extender_id5 = $('#extender_id5');
          var extender5 = {!! $extender5 !!};


          var extender_1 = {!! $extender_1 !!}
          var extender_2 = {!! $extender_2 !!}
          var extender_3 = {!! $extender_3 !!}


          var user_affiliation = $('#user_affiliation');
          extender_id1.select2();
          $('#departmentselect').on('change', function() {
              var selectedepartment = $(this).val();
              console.log(selectedepartment);
              var foundMatch = false;
              extender_id1.empty();
              extender_id1.append('<option value="" selected disabled>-- เลือกสังกัด --</option>');
              $.each(extender1, function(index, exten1) {
                  if (selectedepartment == 1 && exten1.item_group_id == 1) {
                      extender_id1.append($('<option></option>')
                          .attr('value', exten1.extender_id)
                          .text(exten1.name));
                      foundMatch = true;
                  } else if (selectedepartment == 2 && exten1.item_group_id == 2) {
                      extender_id1.append($('<option></option>')
                          .attr('value', exten1.extender_id)
                          .text(exten1.name));
                      foundMatch = true;
                  }
                  user_affiliation.show();
                  sch1Div.show();
                  sch2Div.hide();
                  sch3Div.hide();
                  sch4Div.hide();
                  sch5Div.hide();
              });
              if (selectedepartment == 3) {
                  $.each(extender_1, function(index, exten_1) {
                      extender_id1.append($('<option></option>')
                          .attr('value', exten_1.extender_id)
                          .text(exten_1.content_name));
                      foundMatch = true;
                  });
                  sch1Div.show();
                  sch2Div.hide();
                  sch3Div.hide();
                  sch4Div.hide();
                  sch5Div.hide();
              }
              if (!foundMatch) {
                  sch1Div.hide();
                  sch2Div.hide();
                  sch3Div.hide();
                  sch4Div.hide();
                  sch5Div.hide();
              }
              extender_id1.on('change', function() {
                  var selectedExtenderId = $(this).val();
                  console.log(selectedExtenderId);
                  var foundMatch2 = false;
                  extender_id2.empty();
                  extender_id2.append(
                      '<option value="" selected disabled>-- เลือกหน่วยงาน --</option>');
                  if (selectedExtenderId && selectedepartment == 1 || selectedepartment == 2) {
                      $.each(extender2, function(index, exten2) {
                          if (selectedExtenderId === exten2.item_parent_id) {
                              extender_id2.append($('<option></option>')
                                  .attr('value', exten2.extender_id)
                                  .text(exten2.name));
                              foundMatch2 = true;
                          }
                      });
                      user_affiliation.show();
                      sch2Div.show();
                      sch3Div.hide();
                      sch4Div.hide();
                      sch5Div.hide();
                  } else if (selectedepartment == 3 && selectedExtenderId) {
                      $.each(extender_2, function(index, exten_2) {
                          if (selectedExtenderId === exten_2.id_ref) {
                              extender_id2.append($('<option></option>')
                                  .attr('value', exten_2.extender_id)
                                  .text(exten_2.content_name));
                              foundMatch2 = true;
                          }
                      });
                      sch2Div.show();
                      sch3Div.hide();
                      sch4Div.hide();
                      sch5Div.hide();
                  }
                  if (!foundMatch2) {
                      sch2Div.hide();
                      sch3Div.hide();
                      sch4Div.hide();
                      sch5Div.hide();
                  }
              });
              extender_id2.on('change', function() {
                  var selectedExtenderId3 = $(this).val();
                  console.log(selectedExtenderId3);
                  var foundMatch3 = false;
                  extender_id3.empty();
                  extender_id3.append(
                      '<option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>');
                  if (selectedExtenderId3 && selectedepartment == 1 || selectedepartment == 2) {
                      $.each(extender3, function(index, exten3) {
                          if (selectedExtenderId3 === exten3.item_parent_id) {
                              extender_id3.append($('<option></option>')
                                  .attr('value', exten3.extender_id)
                                  .text(exten3.name));
                              foundMatch3 = true;
                          }
                      });
                      user_affiliation.show();
                      sch3Div.show();
                      sch4Div.hide();
                      sch5Div.hide();
                  } else if (selectedExtenderId3 && selectedepartment == 3) {
                      $.each(extender_3, function(index, exten_3) {
                          if (selectedExtenderId3 == exten_3.id_ref) {
                              extender_id3.append($('<option></option>')
                                  .attr('value', exten_3.extender_id)
                                  .text(exten_3.content_name));
                              foundMatch3 = true;
                          }
                      });
                      sch3Div.show();
                      sch4Div.hide();
                      sch5Div.hide();
                  }
                  if (!foundMatch3) {
                      sch3Div.hide();
                      sch4Div.hide();
                      sch5Div.hide();
                  }
              });
              extender_id3.on('change', function() {
                  var selectedExtenderId4 = $(this).val();
                  console.log(selectedExtenderId4);
                  var foundMatch4 = false;
                  extender_id4.empty();
                  extender_id4.append(
                      '<option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>');
                  if (selectedExtenderId4 && selectedepartment == 1 || selectedepartment == 2) {
                      $.each(extender4, function(index, exten4) {
                          if (selectedExtenderId4 === exten4.item_parent_id) {
                              extender_id4.append($('<option></option>')
                                  .attr('value', exten4.extender_id)
                                  .text(exten4.name));
                              foundMatch4 = true;
                          }
                      })
                      user_affiliation.show();
                      sch4Div.show();
                      sch5Div.hide();
                  }
                  if (!foundMatch4) {
                      sch4Div.hide();
                      sch5Div.hide();
                  }

              });
              extender_id4.on('change', function() {
                  var selectedExtenderId5 = $(this).val();
                  console.log(selectedExtenderId5);
                  var foundMatch5 = false;
                  extender_id5.empty();
                  extender_id5.append(
                      '<option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>');
                  if (selectedExtenderId5 && selectedepartment == 1 || selectedepartment == 2) {
                      $.each(extender5, function(index, exten5) {
                          if (selectedExtenderId5 === exten5.item_parent_id) {
                              extender_id5.append($('<option></option>')
                                  .attr('value', exten5.extender_id)
                                  .text(exten5.name));
                              foundMatch5 = true;
                          }
                      });
                      user_affiliation.show();
                      sch5Div.show();
                  }
                  if (!foundMatch5) {
                      sch5Div.hide();
                  }

              });
          });


      });
  </script>
