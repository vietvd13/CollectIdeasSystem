<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notice for submission of new ideas</title>
  <style>
    body {
      margin: 0;
      padding: 0;

      font-family: 'Open Sans', Arial, sans-serif !important;
    }

    .container {
      width: 90%;

      padding: 5px;

      margin: 0 auto;
    }

    .header {
      width: 100%;
      overflow: hidden;
      display: flex;

      font-weight: 600;

      border-bottom: 2px solid #242368;

      padding: 10px 0 10px 0;

      color: #4a4a4a;

      font-size: 14px;
    }

    .left-header {
      width: 50%;
      overflow: hidden;

      text-align: left;
    }

    .right-header {
      width: 50%;
      overflow: hidden;

      text-align: right;
    }

    .title {
      text-align: center;

      color: #4a4a4a;
    }

    .title h2 {
      font-size: 24px;
    }

    .title h4 {
      font-size: 16px;
    }

    table {
      width: 100%;

      border: 1px solid #c5c5c5;

      border-collapse: collapse;

      margin-bottom: 20px;
    }

    td {
      border: 1px solid #c5c5c5;

      padding: 5px 10px;
    }

    td.title {
      width: 30%;
      overflow: hidden;
      text-align: left;
    }

    td.title .title-table {
      font-size: 14px;
      font-weight: bold;

      margin-bottom: 5px;
    }

    td.title .sub-title-table {
      font-size: 14px;
      font-style: italic;
    }

    td.content {
      justify-content: center;
    }

    td.content ol li {
      margin-bottom: 5px;
    }

    .footer {
      width: 100%;

      text-align: center;

      margin-top: 10px;

      font-style: italic;

      border-top: 2px solid #242368;
    }

    .footer div {
      padding: 10px 0;

      font-size: 14px;

      color: #4a4a4a;

      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="left-header">
        🌎 http://group1.cat-dev.tech/
      </div>
      <div class="right-header">
        Collect Ideas System
      </div>
    </div>

    {{-- "category_id" => $category->id,
    "owner" => $idea->owner,
    "idea_content" => $idea->contents,
    "attatched_files" => isset($fileAttached) ? $fileAttached : null,
    "topic_contents" => $category->contents,
    "created_at" => $idea->created_at
] --}}
    <div class="content">
      <div class="title">
        <h2>Thông báo có ý tưởng mới được nộp!</h2>
        <h4>Notice of new ideas submitted!</h4>
      </div>

      <div class="table-detail">
        <table>
          <tbody>
            <tr>
              <td class="title">
                <div class="title-table">Người nộp</div>
                <div class="sub-title-table">Submitter</div>
              </td>
              <td class="content">
                <div>{{$owner_name}}</div>
              </td>
            </tr>

            <tr>
              <td class="title">
                <div class="title-table">Phòng ban</div>
                <div class="sub-title-table">Department</div>
              </td>
              <td class="content">
                <div>{{$department}}</div>
              </td>
            </tr>

            <tr>
              <td class="title">
                <div class="title-table">Thể loại</div>
                <div class="sub-title-table">Category</div>
              </td>
              <td class="content">
                <div>{{$topic_name}}</div>
              </td>
            </tr>

            <tr>
              <td class="title">
                <div class="title-table">Thời gian</div>
                <div class="sub-title-table">Time</div>
              </td>
              <td class="content">
                <div>{{$attributes['created_at']}}</div>
              </td>
            </tr>

            <tr>
              <td class="title">
                <div class="title-table">Nội dung</div>
                <div class="sub-title-table">Content</div>
              </td>
              <td class="content">
                <div>{{$attributes['idea_content']}}</div>
              </td>
            </tr>

            <tr>
              <td class="title">
                <div class="title-table">File đính kèm</div>
                <div class="sub-title-table">Attached files</div>
              </td>
              <td class="content">
                <div>
                  <ol>
                    @foreach ($attributes['attatched_files'] as $file)
                    <li>
                        <a href="http://group1.cat-dev.tech/storage/{{$file['path']}}">File {{$file['file_extension']}}</a>
                    </li>
                    @endforeach
                  </ol>
                </div>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

    <div class="footer">
      <div>Collect Ideas System</div>
    </div>
  </div>
</body>
</html>
