import { Component } from '@angular/core';
import 'ag-grid-enterprise';
import { messageLogService } from "./log.service";
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
})
export class AppComponent {
  title = 'client';
  private gridApi;
  private gridColumnApi;
  public columnDefs;
  public defaultColDef;
  public rowData;
  public rowModelType;
  public serverSideStoreType;
  public paginationPageSize;
  public autoGroupColumnDef;

  constructor(private messageLogService: messageLogService) {

    this.columnDefs = [
      {
        field: 'log_created',
        filter: 'agDateColumnFilter',
        filterParams: {
          values: params => {
            const field = params.colDef.field;
            this.messageLogService.getValues(field).subscribe(values => params.success(values));
          }
        }
      },
      {
        field: 'cnt_title', filter: 'agSetColumnFilter',
        filterParams: {
          values: params => {
            const field = params.colDef.field;
            this.messageLogService.getValues(field).subscribe(values => params.success(values));
          }
        },
      },
      {
        field: 'usr_name',
        enableRowGroup: true,
        filter: 'agSetColumnFilter',
        filterParams: {
          values: params => {
            const field = params.colDef.field;
            this.messageLogService.getValues(field).subscribe(values => params.success(values));
          }
        }
      },
      { field: 'success' },
      { field: 'failed' }
    ];
    this.defaultColDef = {
      flex: 1,
      minWidth: 100,
      floatingFilter: true,
      sortable: true
    };
    this.rowModelType = 'serverSide';
    this.serverSideStoreType = 'partial';
    this.rowData = [];
    this.autoGroupColumnDef = {
      headerName: 'Group',
      minWidth: 250,
      field: 'created',
      filter: 'agSetColumnFilter',
      filterParams: {
        values: params => {
          const field = params.colDef.field;
          this.messageLogService.getValues(field).subscribe(values => params.success(values));
        }
      }
    }
  }

  onGridReady(params): void {
    this.gridApi = params.api;
    this.gridColumnApi = params.columnApi;

    const datasource = {
      getRows: params => {
        console.log('[Datasource] - rows requested by grid: startRow = ' + params.request.startRow + ', endRow = ' + params.request.endRow);
        let range = params.request.filterModel.log_created;
        if (range) {
          params.request.dateFrom = range.dateFrom;
          params.request.dateTo = range.dateTo;
        }
        // if filtering on group column, then change the filterModel key to have created as key
        if (params.request.filterModel['ag-Grid-AutoColumn']) {
          params.request.filterModel['created'] = params.request.filterModel['ag-Grid-AutoColumn'];
          delete params.request.filterModel['ag-Grid-AutoColumn'];
        }

        this.messageLogService.getLogs(JSON.stringify({ ...params.request })).subscribe(response => params.success({
          rowData: response.rows,
          rowCount: response.lastRow
        }))
      }
    }

    // setting the datasource, the grid will call getRows to pass the request
    params.api.setServerSideDatasource(datasource);
  }

}
