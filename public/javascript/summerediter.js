$(document).ready(function() {
    $('.editor').summernote({
        lang: 'th-TH',
        placeholder: 'เนื้อหาของคุณ...',
        tabsize: 2,
        height: 400, // set editor height
        minHeight: 200, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,

        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['fontsize', ['fontsize']], // เพิ่มแท็บขนาดตัวอักษร
            ['fontname', ['fontname']], // เพิ่มแท็บแบบอักษร
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather'],
        // เพิ่ม Plugin video
        buttons: {
            image: function() {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<i class="note-icon-picture"/>',
                    tooltip: 'แทรกรูปภาพ',
                    click: function() {
                        // จัดการโค้ดเปิดหน้าต่างเพื่อเลือกรูปภาพ
                        // อาจจะใช้ Lightbox หรืออื่น ๆ ตามต้องการ
                        alert('Insert Image dialog here.');
                    }
                });
                return button.render();
            },
            video: function() {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<i class="note-icon-video"/>',
                    tooltip: 'แทรกวิดีโอ',
                    click: function() {
                        // จัดการโค้ดเปิดหน้าต่างเพื่อเลือกวิดีโอ
                        // อาจจะใช้ Lightbox หรืออื่น ๆ ตามต้องการ
                        alert('Insert Video dialog here.');
                    }
                });
                return button.render();
            }
        },

    });
});
