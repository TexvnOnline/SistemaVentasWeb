<template>
  <layout ref="layout">
    <div class="slot_body" slot="component-view">
      <div class="content" style="display: block">
        <div class="card">
          <headerClose :title="'REPORTES DE CLIENTES'"></headerClose>
          <div class="card-title">LISTA DE CLIENTES</div>
          <div class="card-body card-block">
            <br />

            <div class="input-group row col-md-3 mb-1 input-search">
              <input
                class="form-control"
                type="text"
                id="inpBuscar"
                placeholder="Buscar..."
                @focus="hidenav()"
                @blur="shownav()"
              />
              <div class="input-group-append">
                <button class="btn btn-action" type="button">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>

            <table class="table table-hover" id="tblUsuarios">
              <thead>
                <tr>
                  <!-- <th style="width: 75px !important">EDITAR</th> -->
                  <th>DNI</th>
                  <th>TIPO DE PAGO</th>
                  <th>NOMBRES Y APELLIDOS</th>
                  <th>TALLA</th>
                  <th>A CUENTA</th>
                  <th>SALDO</th>
                  <th>FECHA_COMPRA</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(cliente, index) in clientes" :key="index">
                  <td class="table-bordered" align="center">
                    {{ cliente.dni }}
                  </td>
                  <td class="table-bordered">
                    {{ cliente.tipo_pago}}
                  </td>
                  <td class="table-bordered">
                    {{ cliente.nombres + " " + cliente.apellidos}}
                  </td>
                  <td class="table-bordered">
                    {{ cliente.talla }}
                  </td>
                  <td class="table-bordered">
                    {{ cliente.a_cuenta }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ cliente.saldo }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ cliente.created_at }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- <div id="mdlDatosUsuario" class="modal">
        <div class="modal-content w-50">
          <div class="content" style="display: block">
            <div class="card">
              <div
                class="
                  card-header
                  d-flex
                  align-items-center
                  justify-content-between
                "
              >
                <strong>{{ title_modal }}</strong>
                <button
                  type="button"
                  class="btn btn-action"
                  style="border-radius: 50%; float: right !important"
                  @click="Cerrar"
                >
                  <span class="icon text-white">
                    <i class="fas fa-times"></i>
                  </span>
                </button>
              </div>
              <div class="card-title">INFORMACIÓN DEL PROVEEDOR</div>
              <div class="card-body card-block">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link active tab-title"
                      id="datosUsuario1-tab"
                      data-toggle="tab"
                      href="#datosUsuario1"
                      role="tab"
                      aria-controls="datosUsuario1"
                      aria-selected="true"
                      >Datos</a
                    >
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="datosUsuario1"
                    role="tabpanel"
                    aria-labelledby="datosUsuario1-tab"
                  >
                    <div class="form-row">
                      <input
                        type="text"
                        hidden
                        v-model="form_datos_usuario.id"
                      />
                      <div class="form-group col-sm-4">
                        <label class="label-title">DNI / RUC</label>
                        <input
                          :type="txtdni_type"
                          class="form-control center"
                          maxlength="15"
                          style="max-width: 200px"
                          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                          v-model="form_datos_usuario.ruc_dni"
                        />
                      </div>
                      <div class="form-group col-sm-4">
                        <label class="label-title"
                          >NOMBRE EMPRESA / RAZÓN SOCIAL</label
                        >

                        <input
                          type="text"
                          class="form-control centesr"
                          style="max-width: 300px"
                          v-model="
                            form_datos_usuario.nombre_empresa_razon_social
                          "
                        />
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-4">
                        <label class="label-title">NOMBRE CONTACTO</label>

                        <textarea
                          type="text"
                          class="form-control mayus"
                          style="max-width: 300px"
                          rows="1"
                          v-model="form_datos_usuario.nombre_contacto"
                        ></textarea>
                      </div>
                      <div class="form-group col-sm-4">
                        <label class="label-title">CORREO</label>

                        <textarea
                          type="text"
                          class="form-control mayus"
                          style="max-width: 300px"
                          rows="1"
                          v-model="form_datos_usuario.correo"
                        ></textarea>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited && !$v.form_datos_usuario.telefono.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">TELÉFONO</label>

                        <input
                          type="number"
                          class="form-control center"
                          style="max-width: 200px"
                          maxlength="9"
                          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                          v-model="form_datos_usuario.telefono"
                        />
                      </div>
                      <div
                        class="form-group col-sm-8"
                        v-if="
                          form_datos_usuario.modo == 'NUEVO' ||
                          form_datos_usuario.modo == 'EDITAR'
                        "
                      >
                        >
                        <label class="label-title">DIRECCIÓN</label>

                        <textarea
                          rows="1"
                          class="form-control mayus"
                          v-model="form_datos_usuario.direccion"
                        ></textarea>
                      </div>
                    </div>
                  </div>

                  <hr />

                  <div class="text-right">
                    <button
                      class="btn btn-action btn-icon-split"
                      @click="GuardarUsuario"
                    >
                      <span class="icon text-white">
                        <i class="fas fa-save"></i>
                      </span>
                      <span class="text font-size-layout">Guardar</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </layout>
</template>

<script>
import layout from "../Components/layout_prin.vue";
import headerClose from "./../Components/header_close";
import { required } from "vuelidate/lib/validators";
export default {
  components: { layout, headerClose },
  props: {
    clientes: Array,
  },
  data() {
    return {
      windowWidth: window.innerWidth,
      submited: false,
      title_modal: null,
      txtdni_type: "number",
      form_datos_usuario: {
        id: null,
        modo: null,
        ruc_dni: null,
        nombre_empresa_razon_social: null,
        nombre_contacto: null,
        telefono: null,
        direccion: null,
        correo: null,
      },
    };
  },
  validations() {
    if (this.form_datos_usuario.modo == "NUEVO") {
      return {
        form_datos_usuario: {
          telefono: { required },
        },
      };
    } else if (this.form_datos_usuario.modo == "EDITAR") {
      return {
        form_datos_usuario: {
          telefono: { required },
        },
      };
    }
  },
  mounted() {
    window.addEventListener("resize", () => {
      this.windowWidth = window.innerWidth;
      this.AñadirResponsive();
    });
    this.AñadirResponsive();
    this.TablaGestionUsuarios();
  },
  watch: {
    title_modal(new_val) {
      if (new_val == "EDITAR PROVEEDOR") {
        this.txtdni_type = "text";
      } else if (new_val == "NUEVO PROVEEDOR") {
        this.txtdni_type = "number";
      } else {
        this.txtdni_type = "text";
      }
    },
  },
  methods: {
    AñadirResponsive() {
      if (this.windowWidth < 1534) {
        if (!$("#tblUsuarios").hasClass("table-responsive")) {
          document
            .getElementById("tblUsuarios")
            .classList.add("table-responsive");
        }
      } else {
        if ($("#tblUsuarios").hasClass("table-responsive")) {
          document
            .getElementById("tblUsuarios")
            .classList.remove("table-responsive");
        }
      }
    },
    TablaGestionUsuarios() {
      this.$nextTick(() => {
        var table = $("#tblUsuarios").DataTable({
          destroy: true,
          order: [[2, "asc"]],
          scrollCollapse: true,
          fixedHeader: true,
          language: {
            retrieve: true,
            decimal: "",
            emptyTable: "No hay datos disponibles en la tabla",
            info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "No se encontraron registros",
            infoFiltered: "(filtrado de _MAX_ registros)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Agrupar por _MENU_ filas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron registros",
            paginate: {
              first: "Primera",
              last: "Ultima",
              next: '<i class="fas fa-chevron-circle-right" style="font-size:20px;"></i>',
              previous:
                '<i class="fas fa-chevron-circle-left" style="font-size:20px;"></i>',
            },
            aria: {
              sortAscending: ": activar para ordenar de forma ascendente",
              sortDescending: ": activar para ordenar de forma descendente",
            },
          },
          responsive: true,
          dom: '<"top"Bf>rt<"row"<"col-sm-12 col-md-5 mb-2"i><"col-sm-12 col-md-7 mb-2"p><"col-sm-12 col-md-5 mb-2"l>><"clear">',
          buttons: [
            {
              extend: "excelHtml5",
              text: '<i class="fas fa-file-excel"></i> ',
              titleAttr: "Exportar a Excel",
              className: "btn btn-action",
            },
            {
              extend: "pdfHtml5",
              text: '<i class="fas fa-file-pdf"></i> ',
              titleAttr: "Exportar a PDF",
              className: "btn btn-cancel",
            },
            {
              extend: "print",
              text: '<i class="fa fa-print"></i> ',
              titleAttr: "Imprimir",
              className: "btn btn-action",
            },
          ],
        });

        $("#slcAgencias").change(function () {
          if (this.value == 0) {
            table.column($(this).data("index")).search("").draw();
          } else {
            table.column($(this).data("index")).search(this.value).draw();
          }
        });

        $("#inpBuscar").keyup(function () {
          table.search(this.value).draw();
        });
      });
    },
    hidenav() {
      return this.$refs.layout.hide_nav();
    },
    shownav() {
      return this.$refs.layout.show_nav();
    },
    NuevoProveedor() {
      this.submited = false;
      this.title_modal = "NUEVO PROVEEDOR";
      this.form_datos_usuario.ruc_dni = null;
      this.form_datos_usuario.nombre_empresa_razon_social = null;
      this.form_datos_usuario.nombre_contacto = null;
      this.form_datos_usuario.telefono = null;
      this.form_datos_usuario.direccion = null;
      this.form_datos_usuario.correo = null;
      this.form_datos_usuario.modo = "NUEVO";

      $("#mdlDatosUsuario").css("display", "block");
      $("#datosUsuario1-tab").tab("show");
    },
    EditarUsuario(proveedor) {
      this.submited = false;
      this.title_modal = "EDITAR PROVEEDOR";
      this.form_datos_usuario.id = proveedor.id;
      this.form_datos_usuario.ruc_dni = proveedor.ruc_dni;
      this.form_datos_usuario.nombre_empresa_razon_social = proveedor.nombre_empresa_razon_social;
      this.form_datos_usuario.nombre_contacto = proveedor.nombre_contacto;
      this.form_datos_usuario.telefono = proveedor.telefono;
      this.form_datos_usuario.direccion = proveedor.direccion;
      this.form_datos_usuario.correo = proveedor.correo;

      this.form_datos_usuario.modo = "EDITAR";
      $("#mdlDatosUsuario").css("display", "block");
      $("#datosUsuario1-tab").tab("show");
      $("#btnCancelar").click(function () {
        $("#mdlDatosUsuario").css("display", "none");

        $("#datosUsuario1-tab").tab("show");
      });
    },

    Cerrar() {
      $("#mdlDatosUsuario").css("display", "none");
      $("#datosUsuario1-tab").tab("show");
    },
    GuardarUsuario() {
      this.submited = true;
      self = this;
      if (this.$v.form_datos_usuario.$invalid) {
        Swal.fire({
          icon: "error",
          title: "¡Ups!",
          text: "Hay uno o más campos vacíos, verifique.",
        });
        return false;
      } else {
        Swal.fire({
          title: "GUARDAR CAMBIOS",
          text: "¿Desea continuar?",
          confirmButtonText:
            '<i class="fas fa-check" style="color:white;"></i>   Si',
          confirmButtonColor: "var(--colorAlto)",
          showCancelButton: true,
          cancelButtonText: '<i class="fas fa-times"></i>   No',
          cancelButtonColor: "var(--plomoOscuroEmpresarial)",
          allowOutsideClick: false,
          preConfirm: () => {
            // console.log(self.form_datos_usuario);
            // self.$inertia.post(route("usuarios_gestion.guardar"), self.form_datos_usuario);

            self.$inertia.post(
              route("proveedores.guardar"),
              self.form_datos_usuario,
              {
                preserveScroll: true,
                onStart: (visit) => {
                  let timerInterval;
                  Swal.fire({
                    title: "EN PROGRESO",
                    html: "Espere porfavor...",
                    timer: 5000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getContent();
                        if (content) {
                          const b = content.querySelector("b");
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                    },
                  });
                },
                onSuccess: () => {
                  Swal.fire({
                    icon: "success",
                    title: "¡ÉXITO!",
                    allowOutsideClick: false,
                    preConfirm: (result) => {
                      self.submited = false;
                      self.Cerrar();
                      $("#tblUsuarios").DataTable().destroy();
                      this.TablaGestionUsuarios();
                      $("#mdlSuministrosActivos").css("display", "none");
                      $("#footer-navigator").css("display", "flex");
                    },
                  });
                },
              }
            );
          },
        });
        // }
        //   });
      }
    },
  },
};
</script>

<style>
</style>