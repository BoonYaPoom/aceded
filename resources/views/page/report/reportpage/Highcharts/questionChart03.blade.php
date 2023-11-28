
    <td>{!! $item->question !!}</td>
    <td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
    </td>
</tr>
<tr>
    <td colspan="2" class="text-left" align="left">
        <div class="container">
            <h4 class="card-title">ความคิดเห็น </h4>
            <ul class="list-icons mb-3 ">
                <li><span class="list-icon"><span
                            class="fas fa-comment-alt text-success"></span></span> -
                </li>
            </ul>
        </div>
    </td><!-- /grid row -->
    <td>
        <table>

        </table>
    </td>
</tr>
