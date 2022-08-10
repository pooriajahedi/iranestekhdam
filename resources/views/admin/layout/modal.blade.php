<div id="modal-delete" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">پیام سیستم</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">بستن</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    آیا از حذف این آیتم اطمینان دارید؟
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow" data-dismiss="modal">بستن</button>
                <a href="javascript:void(0);" class="btn btn-danger">بله اطمینان دارم</a>
            </div>
        </div>
    </div>
</div>
<div id="modal-confirm" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">پیام سیستم</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">بستن</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    آیا از انجام این عملیات اطمینان دارید؟
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow" data-dismiss="modal">بستن</button>
                <a href="javascript:void(0);" class="btn btn-danger">بله اطمینان دارم</a>
            </div>
        </div>
    </div><div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">پیام سیستم</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">بستن</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    آیا از انجام این عملیات اطمینان دارید؟
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow" data-dismiss="modal">بستن</button>
                <a href="javascript:void(0);" class="btn btn-danger">بله اطمینان دارم</a>
            </div>
        </div>
    </div>
</div>
<div id="modal-reject" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">آیا از انجام این عملیات اطمینان دارید؟</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">بستن</span>
                </button>
            </div>
            <form method="post" action="/admin/order/reject">
                <div class="modal-body">
                    <input type="hidden" name="id" id="order_id">
                    <div class="form-group">
                        <label>دلیل ریفاند</label>
                        <textarea class="form-control" rows="10" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-shadow" data-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-danger">بله اطمینان دارم</button>
                </div>
            </form>
        </div>
    </div>
</div>
