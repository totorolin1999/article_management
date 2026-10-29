import Swal from "sweetalert2";

export const showSuccess = (title, text = "") => {
  return Swal.fire({
    icon: "success",
    title,
    text,
    timer: 2000,
    showConfirmButton: false,
  });
};

export const showError = (title, text = "") => {
  return Swal.fire({
    icon: "error",
    title,
    text,
  });
};

export const confirmAction = async (text = "你確定要刪除這筆資料嗎？", title = "確認操作") => {
  const result = await Swal.fire({
    title,
    text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "確定刪除",
    cancelButtonText: "取消",
  });
  return result.isConfirmed;
};
