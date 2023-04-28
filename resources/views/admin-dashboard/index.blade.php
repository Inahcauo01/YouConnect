<x-app-layout >
        
    <div class="container-fluid" id="dashboard" style="margin-top: 4rem">
        <div class="row">
            <div class="col-2 col-md-3 col-lg-2 px-sm-2 px-0 bg-light shadow " style="min-height: 52rem">
                <div id="toTop">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3  text-white min-vh-100  position-fixed ">
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item mb-4">
                                <a href="/" class="nav-link align-middle px-0 text-dark">
                                    <i class="bi bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            <hr>
                            <li class="mb-4">
                                <a href="#statistics" class="nav-link px-0 align-middle text-dark">
                                    <i class="bi bi-grid-3x3-gap"></i> <span class="ms-1 d-none d-sm-inline">Statistiques</span>
                                </a>
                            </li>
                            <hr>
                            <li class="mb-4">
                                <a href="#posts" class="nav-link px-0 align-middle text-dark">
                                    <i class="bi bi-bar-chart"></i> <span class="ms-1 d-none d-sm-inline">Posts</span>
                                </a>
                            </li>
                            <hr>
                            <li class="mb-4">
                                <a href="#commentaires" class="nav-link px-0 align-middle text-dark">
                                    <i class="bi bi-bar-chart"></i> <span class="ms-1 d-none d-sm-inline">Commentaires</span>
                                </a>
                            </li>
                            <hr>
                            <li class="mb-4">
                                <a href="#users" class="nav-link px-0 align-middle text-dark">
                                    <i class="bi bi-bar-chart"></i> <span class="ms-1 d-none d-sm-inline">Utilisateurs</span>
                                </a>
                            </li>
                            <hr>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-10 col-md-9 col-lg-10 py-2" >
                <div class="container">
                    <!-- statistics -->
                    <div class="row ">
                        <div class="col-12 mt-3 mb-1">
                        <h4 id="statistics" class="text-uppercase fw-bold">Statistics</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-people"></i>
                                    <h3>{{$users->count()}}</h3>
                                    <p>Users</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-houses"></i>
                                    <h3>{{$tags->count()}}</h3>
                                    <p>Tags</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-bookmarks"></i>
                                    <h3>{{$posts->count()}}</h3>
                                    <p>Posts</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-chat-left-dots"></i>
                                    <h3>{{number_format($tagsParPost, 2)}}</h3>
                                    <p>Tags / Posts</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-boxes"></i>
                                    <h3>{{$userActif}}</h3>
                                    <p>Active users</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2 col-sm-10 col-12 mb-2">
                            <div class="card row border rounded p-3 mx-1">
                                <div class="text-center">
                                    <i class="bi bi-box"></i>
                                    <h3>{{number_format($averagePostsPerUser)}}</h3>
                                    <p>User / post</p>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>

                <div id="columnchart_values" class="m-4" style="height: 600px;"></div>
                
                {{-- les posts --}}
                <div class="row items-center me-0">
                    <h1 id="posts" class="col fw-bold ms-3 mt-5">Les posts</h1>  
                </div>
                <div class="container pt-5 table-responsive">     
                    <table class="table text-center">
                        <thead class="table-dark">
                            <th>Nom d'utilisateurs</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Date de creation</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->user->name}}</td>
                                <td><small>{{$post->post_desc}}</small></td>
                                <td class="d-flex justify-content-center">
                                    @if ($post->post_image)
                                        <img src="{{ asset('images/'.$post->post_image) }}" class="rounded" style="object-fit: contain;width: 80px;">
                                    @else
                                        <span class="text-center">---</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($post->tags as $tag)
                                        <small class="bg-info rounded-pill p-1">{{$tag->name}}</small>
                                    @endforeach
                                </td>
                                <td><small>{{$post->created_at}}</small></td>
                                <td><a href="">
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#5f72ce"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 7H20" stroke="#2f68b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7" stroke="#2f68b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#2f68b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>      
                </div>
                {{-- les commentaires --}}
                <div class="row items-center me-0">
                    <h1 id="commentaires" class="col fw-bold ms-3 mt-5">Les Commentaires</h1>  
                </div>
                <div class="container pt-5 table-responsive">     
                    <table class="table text-center">
                        <thead class="table-dark">
                            <th>Post desc</th>
                            <th>Post Image</th>
                            <th>Commentaire</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{$comment->user->name}}</td>
                                    <td class="d-flex justify-content-center">
                                        @if ($comment->post->post_image)
                                            <img src="{{ asset('images/'.$comment->post->post_image) }}" class="rounded" style="object-fit: contain;width: 80px;">
                                        @else
                                            <span class="text-center">---</span>
                                        @endif
                                    </td>
                                    <td>{{$comment->content}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>      
                </div>

                {{-- les utilisateurs --}}
                <div class="row items-center me-0">
                    <h1 id="users" class="col fw-bold ms-3 mt-5">Les utilisateurs</h1>  
                </div>
                <div class="container pt-5 table-responsive">     
                    <table class="table text-center">
                        <thead class="table-dark">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Nombre de posts</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->getRoleNames()}}</td>
                                    {{-- <td>{{$user->roles->name}}</td> --}}
                                    <td>{{$user->posts->count()}}</td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>      
                </div>
            </div>
        </div>
    </div>
    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          < ?php echo $data; ?>
        ]);

        var options = {
          title: 'Nombre des postes par utilisateur',
          is3D: false,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script> --}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["users", " nombre de posts", { role: "style" } ], 
        <?php echo $data; ?>
        // ["Silver", 10, "silver"],
        // ["Gold", 19, "gold"],
        // ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

    var options = {
        title: "Nombre des postes par utilisateur",
        hAxis: {
            title: "Users",
            minValue: 1,
            format: '####'
        },
        vAxis: {
            title: "Nombre de posts",
            format: '0',
            minValue: 0
        },
        // width: 1000,
        // height: 400,
        bar: {groupWidth: "20%"},
        legend: { position: "none" },
    };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>

</x-app-layout>