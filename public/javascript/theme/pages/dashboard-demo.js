"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

// Dashboard Demo
// =============================================================
var DashboardData =
/*#__PURE__*/
function () {
  function DashboardData() {
    _classCallCheck(this, DashboardData);

    this.init();
  }

  _createClass(DashboardData, [{
    key: "init",
    value: function init() {
      // event handlers
       this.table = this.table();
    }
  }, {
    key: "table",
    value: function table() {
		return $('#datatables').DataTable({
		dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
	    language: {
			"lengthMenu": "&nbsp;แสดงหน้าละ _MENU_ รายการ&nbsp;",
			"zeroRecords": "&nbsp;ไม่พบรายการแสดงข้อมูล",
			"emptyTable": "&nbsp;ไม่พบรายการแสดงข้อมูล",
			"info": "&nbsp;แสดง _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ&nbsp;",
			"infoEmpty": "&nbsp;ไม่พบรายการแสดงข้อมูล",
			"infoFiltered": "&nbsp;(กรอกข้อมูล _MAX_ รายการ)&nbsp;",
			"search": "&nbsp;ค้นหา",
			"processing": "&nbsp;รอสักครู่...",
			"loadingRecords": "&nbsp;ไม่พบรายการแสดงข้อมูล",
			  paginate: {
				previous: '<i class="fa fa-lg fa-angle-left"></i>',
				next: '<i class="fa fa-lg fa-angle-right"></i>'
			  }
        }
		});
    }
  }]);
  return DashboardData;
}();
/**
 * Keep in mind that your scripts may not always be executed after the theme is completely ready,
 * you might need to observe the `theme:load` event to make sure your scripts are executed after the theme is ready.
 */
$(document).on('theme:init', function () {
  new DashboardData();
});
