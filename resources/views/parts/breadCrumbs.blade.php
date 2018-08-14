<div class="row">
    <div class="col-lg-12 col-sm-12">
        <ol class="breadcrumb">
            @php
                /** @var $breadCrumbs \App\Services\BreadCrumbs\lib\Items\BreadCrumbsItem */
            @endphp
            @foreach($breadCrumbs->getPaths() as $breadCrumb)
                <li>
                    <a href="{{$breadCrumb->getUrl()}}">{{$breadCrumb->getName()}}</a>
                </li>
            @endforeach
            <li>
                <a href="#">{{$breadCrumbs->getCurrentPage()->getName()}}</a>
            </li>
        </ol>
    </div>
</div>