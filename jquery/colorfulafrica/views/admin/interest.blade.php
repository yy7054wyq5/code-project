@extends('admin.adminbase')

@section('title', '平台管理员列表')
@section('head')
    {{--@parent--}}
    {{--<meta http-equiv="content-type" content="text/html; charset=UTF-8">--}}
    {{--<link rel="stylesheet" href="/zTree_v3/css/demo.css" type="text/css">--}}
    <link rel="stylesheet" href="/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <link rel="stylesheet" href="/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

    {{--<script type="text/javascript" src="/zTree_v3/js/jquery-1.4.4.min.js"></script>--}}
    <script type="text/javascript" src="/zTree_v3//js/jquery.ztree.all-3.5.js"></script>

@endsection

@section('content')
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

    <div id="zTreeNode" style="display: none">
        <?echo  $zTreeNode;?>
    </div>
    <div class="content_wrap">
        <ul id="treeDemo" class="ztree"></ul>
    </div>
    <form id="imgUpload" style="display: none;">
        <input type="file" name="image" id="imageInput">
    </form>
    <SCRIPT type="text/javascript">
        var setting = {
            async:{
                enable: true,
                url: "/admin/interest/child-data",
                autoParam: ["id", 'name'],
                otherParam:{"_token": $('#_token'). val()}
            },
            edit: {
                enable: true,
                showRemoveBtn: canRemove,
                removeTitle: "删除兴趣",
                showRenameBtn: canEdit,
                renameTitle: "编辑兴趣",
                drag: {
                    isCopy: false,
                    isMove:false,
                    prev: canDrag,
                    next: canDrag,
                    inner: false
                }
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            view: {
                addHoverDom: addHoverDom,
                removeHoverDom: removeHoverDom,
                selectedMulti: false
            },
            callback: {
                beforeRename: zTreeBeforeRename,
                beforeRemove:zTreeBeforeRemove,
                onRemove:zTreeOnRemove,
                onAsyncSuccess: zTreeOnAsyncSuccess,
                beforeDblClick: zTreeBeforeDblClick
            }
        };



        var zNodes =JSON.parse($('#zTreeNode').text());
                $(function(){
                    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
                });
//
        function zTreeOnAsyncSuccess(event, treeId, treeNode, $result) {
            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//alert("异步获取数据成功");
            zTree.updateNode(treeNode);
//            $.fn.zTree.init($("#treeDemo"), setting, $result.zTreeNode);
            return false;
//            alert($result);
        }


        function addHoverDom(treeId, treeNode) {
            var sObj = $("#" + treeNode.tId + "_span");
            if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;

            if (parseInt(treeNode.levelMy) <= 1) {
                var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
                        + "' title='新增兴趣' onfocus='this.blur()'></span>";
                sObj.append(addStr);
                var btn = $("#addBtn_"+treeNode.tId);
                if (btn) btn.bind("click", function(){
                    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                    var data = {};
                    data.id = treeNode.id;
                    data.name = '新兴趣' + parseInt(10000 * Math.random());
                    $.get('/admin/interest/add', data, function (res) {
                        if (res.status == 'success') {
                            location.href = '/admin/interest/lists?id=' + treeNode.id;
                            return true;
                        }
                        return false
                    }, 'json');
                    return false;
                });
            }

            if (parseInt(treeNode.levelMy) >= 1) {
                if ($("#diyBtn_" + treeNode.id).length > 0) return false;
                var len = treeNode.getParentNode().children.length, selectStr = '<select>', ordinal= treeNode.ordinal;
                for (var i = 1; i <= len; i++) {
                    if (i == ordinal) {
                        selectStr += "<option selected='selected' value=" + i + ">" + i + "</option>"
                    } else {
                        selectStr += "<option value=" + i + ">" + i + "</option>"
                    }
                }
                selectStr += "</select>"
                var aObj = $("#" + treeNode.tId + "_a");
                var editStr = "<span id='diyBtn_" + treeNode.id + "' title='排序'>" + selectStr + "</span>";
                aObj.append(editStr);
                var divBtn = $("#diyBtn_" + treeNode.id);
                if (divBtn) divBtn.bind("change", function () {
                    console.log($(this).children('select').val());
                    var data = {id:treeNode.id, ordinal:$(this).children('select').val()};
                    $.get('/admin/interest/update', data, function (res) {
                        if (res.status == 'success') {
                            location.href = '/admin/interest/lists?id=' + treeNode.pid;
                            return true;
                        }
                        return false
                    }, 'json');
                    return false;
//                    alert("diy Select value=" + divBtn.attr("value") + " for " + treeNode.name);
                });
            }
        }

        function removeHoverDom(treeId, treeNode) {
            $("#addBtn_"+treeNode.tId).unbind().remove();
            $("#diyBtn_"+treeNode.id).unbind().remove();
            $("#diyBtn_title_"+treeNode.id).unbind().remove();
        }


        function zTreeBeforeRemove(treeId, treeNode) {
            if (treeNode.children && treeNode.children.length >0) {
                alert('该兴趣下面还有子兴趣，不能删除');
                return false;
            }
            $.get('/admin/interest/remove?id=' + treeNode.id, null, function (res) {
                if (res.status == 'success') {
                    location.href = '/admin/interest/lists?id=' + treeNode.pid;
                    return true;
                }
                return false
            }, 'json');
            return false;
        }


        function zTreeBeforeRename(reeId, treeNode, newName, isCancel)
        {
            if (newName.length <2 || newName.length > 7) return false;
//            return newName.length > 5;
//            if (treeNode.children && treeNode.children.length >0) {
//                alert('该兴趣下面还有子兴趣，不能删除');
//                return false;
//            }
            var data = {id:treeNode.id, name:newName};
            $.get('/admin/interest/update', data, function (res) {
                if (res.status == 'success') {
                    location.href = '/admin/interest/lists?id=' + treeNode.pid;
                    return true;
                }
                return false
            }, 'json');
            return false;

        }

        function zTreeOnRemove(event, treeId, treeNode) {
            alert(treeNode.tId + ", " + treeNode.name);
        }
        function zTreeBeforeDblClick(treeId, treeNode) {
            if (treeNode && treeNode.levelMy && treeNode.levelMy == 1) {
                $('#imageInput').unbind();
                $('#imageInput').click();
                $('#imageInput').on('change', function () {
                    $('#imgUpload').ajaxSubmit({
                        dataType: "json",
                        type: 'post',
                        url: '/admin/interest/update?id='+treeNode.id,
                        data: $('#image').val(),
                        resetForm: true,
                        success: function (res) {
                            if (res.status == 'success' && res.picKey) {
                                treeNode.icon = '/image/' + res.picKey;
                                console.log(treeNode);
                            } else {
                                alert(res.msg);
                            }
                        }
                    });
                });
            }
            return true;
        }


        function canDrag(treeId, nodes, targetNode) {
            return (nodes[0].pid == targetNode.pid);
        }


        function canEdit(treeId, treeNode) {
            return parseInt(treeNode.level) >= 1;
        }


        function canRemove(treeId, treeNode) {
            return parseInt(treeNode.level) >= 1;
        }
        //-->
    </SCRIPT>




@endsection