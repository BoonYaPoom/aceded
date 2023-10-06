document.querySelectorAll(".editor").forEach((element) => {
    CKEDITOR.basePath = 'ckeditor5/';
    
    CKEDITOR.ClassicEditor.create(element, {
        
        toolbar: {
            items: [
                "exportPDF",
                "exportWord",
                "|",
                "findAndReplace",
                "selectAll",
                "|",
                "heading",
                "|",
                "bold",
                "italic",
                "strikethrough",
                "underline",
                "code",
                "subscript",
                "superscript",
                "removeFormat",
                "|",
                "bulletedList",
                "numberedList",
                "todoList",
                "|",
                "outdent",
                "indent",
                "|",
                "undo",
                "redo",
                "-",
                "fontSize",
                "fontFamily",
                "fontColor",
                "fontBackgroundColor",
                "highlight",
                "|",
                "alignment",
                "|",
                "link",
                "insertImage",
                "blockQuote",
                "insertTable",
                "mediaEmbed",
                "codeBlock",
                "htmlEmbed",
                "|",
                "specialCharacters",
                "horizontalLine",
                "pageBreak",
            
                "|",
                "sourceEditing",
            ],
            shouldNotGroupWhenFull: true,
        },
        language: 'th',
        
        enterMode: CKEDITOR.ENTER_BR,  // กำหนดให้ใช้ <br> สำหรับการแยกบรรทัด
        shiftEnterMode: CKEDITOR.ENTER_P,  // กำหนดให้ใช้ <p> สำหรับการแยกบรรทัดด้วย Shift+Enter
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true,
            },
        },
        heading: {
            options: [
                {
                    model: "paragraph",
                    title: "Paragraph",
                    class: "ck-heading_paragraph",
                },
                {
                    model: "heading1",
                    view: "h1",
                    title: "Heading 1",
                    class: "ck-heading_heading1",
                },
                {
                    model: "heading2",
                    view: "h2",
                    title: "Heading 2",
                    class: "ck-heading_heading2",
                },
                // คุณสามารถเพิ่มตัวเลือกของหัวข้อเพิ่มเติมได้ที่นี่
            ],
        },
        placeholder: "",
        fontFamily: {
            options: [
                "default",
                "Arial, Helvetica, sans-serif",
                "Courier New, Courier, monospace",
                "Georgia, serif",
                "Lucida Sans Unicode, Lucida Grande, sans-serif",
                "Tahoma, Geneva, sans-serif",
                "Times New Roman, Times, serif",
                "Trebuchet MS, Helvetica, sans-serif",
                "Verdana, Geneva, sans-serif",
            ],
            supportAllValues: true,
        },
        fontSize: {
            options: [10, 12, 14, "default", 18, 20, 22],
            supportAllValues: true,
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true,
                },
            ],
        },
        htmlEmbed: {
            showPreviews: true,
        },
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: "https://",
                toggleDownloadable: {
                    mode: "manual",
                    label: "Downloadable",
                    attributes: {
                        download: "file",
                    },
                },
            },
        },
        mention: {
            feeds: [
                {
                    marker: "@",
                    feed: [
                        "@apple",
                        "@bears",
                        "@brownie",
                        "@cake",
                        "@cake",
                        "@candy",
                        "@canes",
                        "@chocolate",
                        "@cookie",
                        "@cotton",
                        "@cream",
                        "@cupcake",
                        "@danish",
                        "@donut",
                        "@dragée",
                        "@fruitcake",
                        "@gingerbread",
                        "@gummi",
                        "@ice",
                        "@jelly-o",
                        "@liquorice",
                        "@macaroon",
                        "@marzipan",
                        "@oat",
                        "@pie",
                        "@plum",
                        "@pudding",
                        "@sesame",
                        "@snaps",
                        "@soufflé",
                        "@sugar",
                        "@sweet",
                        "@topping",
                        "@wafer",
                    ],
                    minimumCharacters: 1,
                },
            ],
        },
        removePlugins: [
            "CKBox",
            "CKFinder",
            "EasyImage",
            "RealTimeCollaborativeComments",
            "RealTimeCollaborativeTrackChanges",
            "RealTimeCollaborativeRevisionHistory",
            "PresenceList",
            "Comments",
            "TrackChanges",
            "TrackChangesData",
            "RevisionHistory",
            "Pagination",
            "WProofreader",
            "MathType",
            "SlashCommand",
            "Template",
            "DocumentOutline",
            "FormatPainter",
            "TableOfContents",
            "PasteFromOfficeEnhanced",
        ],
    })
        .then((editor) => {
            console.log("Rich text editor ถูกสร้างขึ้นแล้ว");
        })
        .catch((error) => {
            console.error("เกิดข้อผิดพลาดในการสร้าง rich text editor:", error);
        });
});
