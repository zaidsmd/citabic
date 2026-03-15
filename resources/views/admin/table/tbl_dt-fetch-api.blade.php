@extends('admin.layouts.master')

@section('title', 'Fetch API')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/style.css" />
@endsection

@section('content')

<x-breadcrumb item="Table" active="Fetch API"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- prettier-ignore -->
          <x-link title="Simple-datatables" text="A lightweight, extendable, JavaScript HTML table library written in TypeScript and transpilled to Vanilla JavaScript. Similar to jQuery DataTables for use in modern browsers, but without the jQuery dependency." link="https://github.com/fiduswriter/simple-datatables"/>
        </div>
        <div class="row">
          <!-- [ basic-table ] start -->
          <div class="col-xl-12">
            <div class="card">
              <div class="card-header">
                <h5>Fetch API</h5>
              </div>
              <div class="card-body table-border-style">
                <div class="table-responsive">
                  <table class="table" id="pc-dt-fetchapi"> </table>
                </div>
              </div>
            </div>
          </div>
          <!-- [ basic-table ] end -->
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="/build/js/plugins/simple-datatables.js"></script>
    <script>
      fetch('/build/json/datatable.json')
        .then((response) => response.json())
        .then((data) => {
          if (!data.length) {
            return;
          }

          let table = new simpleDatatables.DataTable('#pc-dt-fetchapi', {
            data: {
              headings: Object.keys(data[0]),
              data: data.map((item) => Object.values(item))
            }
          });
        });
    </script>
    <!-- [Page Specific JS] end -->
@endsection
