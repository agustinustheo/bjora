@extends('layout.application')
@section('content')
    <div class="col-md-10 mx-auto">
        <form class="form-group mt-4 mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white lighten-3 p-2" id="basic-text1">
                        <i class="fas fa-search text-muted" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control border-left-0 search-input" placeholder="Search by Question or Username">
            </div>
        </form>
        <div>
            <div class="border rounded p-3">
                <span class="text-muted">Finance</span>
                <h3>What is the greatest paradox of becoming wealthy?</h3>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-dark display-picture">

                    </div>
                    <div class="ml-2">
                        <div class="text-danger">Abraham Lincoln</div>
                        <div>
                            <span class="font-weight-bold text-dark">Created At:</span>
                            <span class="text-muted"><?php echo date('Y-m-d H:i:s'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="btn btn-danger text-white mt-2">
                    Answer
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                <a class="page-link text-muted" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <li class="page-item"><a class="page-link text-danger" href="#">1</a></li>
                <li class="page-item">
                <a class="page-link text-muted" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection