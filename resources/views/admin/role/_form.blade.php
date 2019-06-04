<div class="form-group">
    <label for="tag" class="col-md-3 control-label">角色名称</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" id="tag" value="{{ $name }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">角色概述</label>
    <div class="col-md-5">
        <textarea name="description" class="form-control" rows="3">{{ $description }}</textarea>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">权限列表</label>
</div>
<div class="form-group">
    <div class="form-group">
        @if($permissionAll)
            @foreach($permissionAll[0] as $v)
                <div class="form-group">
                    <label class="control-label col-md-3 all-check cursor">
                        <input class="form-actions select-all" type="Checkbox" @if(count($permissionAll[$v['id']]) == count(array_intersect(array_column($permissionAll[$v['id']], 'id'), $permissions))) checked @endif>
                        {{$v['label']}}：
                    </label>
                    <div class="col-md-6">
                        @if(isset($permissionAll[$v['id']]))

                            @foreach($permissionAll[$v['id']] as $vv)
                                <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
                                    <span class="checkbox-custom checkbox-default">
                                        <i class="fa"></i>
                                        <label for="inputChekbox{{$vv['id']}}" class="cursor select-one">
                                            <input class="form-actions"
                                                   @if(in_array($vv['id'],$permissions))
                                                   checked
                                                   @endif
                                                   id="inputChekbox{{$vv['id']}}" type="Checkbox" value="{{$vv['id']}}"
                                                   name="permissions[]">
                                                {{$vv['label']}}
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<style>
    .cursor{
        cursor: pointer;
    }
</style>
@section('js')
    @parent
    <script>
        $(function () {

            $('.all-check').on('ifChecked ifUnchecked',function(event){
                var _this = $(this);
                if(event.type == 'ifChecked'){
                    _this.parent().find('input').iCheck('check');
                }else{
                    _this.parent().find('input').iCheck('uncheck');
                }
            });

            $('.select-one').on('ifChanged',function(event){
                var _this = $(this);
                var _all_same = _this.parent().parent().parent().find('input');
                var _all = _this.parent().parent().parent().parent().find('.select-all');
                if(_all_same.filter(':checked').length == _all_same.length){
                    _all.prop('checked',true);
                }else{
                    _all.prop('checked',false);
                }
                _all.iCheck('update');
            });
        });
    </script>
@endsection

