<template>
  <layout ref="layout">
    <div class="slot_body" slot="component-view">
      <div class="content" style="display: block">
        <div class="card">
          <headerClose :title="'GESTIÓN DE DOCTORES'"></headerClose>
          <div class="card-title">LISTA DE DOCTORES</div>
          <div class="card-body card-block">
            <div class="text-center">
              <button
                class="btn btn-action btn-icon-split"
                @click="NuevoDoctor"
              >
                <span class="icon text-white">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text font-size-layout">Nuevo Doctor</span>
              </button>
            </div>
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
                  <th style="width: 75px !important">EDITAR</th>
                  <th>DNI</th>
                  <th>CARGO</th>
                  <th>APELLIDOS_NOMBRES</th>
                  <th>ESPECIALIDAD</th>
                  <th>TELÉFONO</th>
                  <th>CLINICA_1</th>
                  <th>CLINICA_2</th>
                  <th>SEDE</th>
                  <th>HABILITADO</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(usuario, index) in usuarios" :key="index">
                  <td class="table-bordered" align="center">
                    <button
                      class="btn btn-action"
                      type="button"
                      title="Editar datos"
                      @click="EditarUsuario(usuario)"
                    >
                      <span class="icon text-white">
                        <i class="fas fa-edit"></i>
                      </span>
                    </button>
                  </td>
                  <td class="table-bordered" align="center">
                    {{ usuario.dni }}
                  </td>
                  <td class="table-bordered">
                    {{ usuario.cargo }}
                  </td>
                  <td class="table-bordered">
                    {{
                      usuario.apellidoPaterno +
                      " " +
                      usuario.apellidoMaterno +
                      " " +
                      usuario.nombres
                    }}
                  </td>
                  <td class="table-bordered">
                    {{ usuario.especialidad }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ usuario.telefono }}
                  </td>
                  <td class="table-bordered">
                    {{ usuario.clinica_uno }}
                  </td>
                  <td class="table-bordered">
                    {{ usuario.clinica_dos }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ usuario.sedes }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ usuario.habilitado == 1 ? "Si" : "No" }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div id="mdlDatosUsuario" class="modal">
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
              <div class="card-title">INFORMACIÓN PERSONAL</div>
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
                      >Datos personales</a
                    >
                  </li>
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link tab-title"
                      id="datosUsuario2-tab"
                      data-toggle="tab"
                      href="#datosUsuario2"
                      role="tab"
                      aria-controls="datosUsuario2"
                      aria-selected="false"
                      ><i class="fas fa-plus-square"></i
                    ></a>
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
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited &&
                            form_datos_usuario.modo == 'NUEVO' &&
                            !$v.form_datos_usuario.dni.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">DNI</label>
                        <input
                          :type="txtdni_type"
                          class="form-control center"
                          maxlength="8"
                          style="max-width: 200px"
                          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                          v-model="form_datos_usuario.dni"
                          :disabled="form_datos_usuario.modo == 'EDITAR DOCTOR'"
                        />
                      </div>
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited && !$v.form_datos_usuario.usuario.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">USUARIO</label>

                        <input
                          type="text"
                          class="form-control center"
                          style="max-width: 200px"
                          v-model="form_datos_usuario.usuario"
                        />
                      </div>
                      <div class="form-group col-sm-4">
                        <label class="label-title">ESPECIALIDAD</label>

                        <input
                          type="text"
                          class="form-control center"
                          style="max-width: 300px"
                          v-model="form_datos_usuario.especialidad"
                          :disabled="form_datos_usuario.modo == 'EDITAR DOCTOR'"
                        />
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited &&
                            !$v.form_datos_usuario.apellidoPaterno.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">APELLIDO PATERNO</label>

                        <textarea
                          type="text"
                          class="form-control mayus"
                          style="max-width: 300px"
                          rows="1"
                          v-model="form_datos_usuario.apellidoPaterno"
                        ></textarea>
                      </div>
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited &&
                            !$v.form_datos_usuario.apellidoMaterno.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">APELLIDO MATERNO</label>

                        <textarea
                          type="text"
                          class="form-control mayus"
                          style="max-width: 300px"
                          rows="1"
                          v-model="form_datos_usuario.apellidoMaterno"
                        ></textarea>
                      </div>
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited && !$v.form_datos_usuario.nombres.required
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">NOMBRES</label>

                        <textarea
                          type="text"
                          class="form-control mayus"
                          style="max-width: 300px"
                          rows="1"
                          v-model="form_datos_usuario.nombres"
                        ></textarea>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <label class="label-title">CLINICA 1</label>

                        <input
                          type="text"
                          class="form-control center"
                          style="max-width: 300px"
                          v-model="form_datos_usuario.clinica_uno"
                        />
                      </div>
                      <div class="form-group col-sm-6">
                        <label class="label-title">CLINICA 2</label>

                        <input
                          type="text"
                          class="form-control center"
                          style="max-width: 300px"
                          v-model="form_datos_usuario.clinica_dos"
                        />
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="datosUsuario2"
                    role="tabpanel"
                    aria-labelledby="datosUsuario2-tab"
                  >
                    <div class="form-row"></div>
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
                      <div class="form-group col-sm-4">
                        <span
                          v-if="
                            submited && !$v.form_datos_usuario.id_sede.noZero
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">SEDE</label>
                        <select
                          type="text"
                          class="form-control center"
                          style="max-width: 300px"
                          v-model="form_datos_usuario.id_sede"
                          :disabled="true"
                        >
                          <option value="0">Seleccione...</option>
                          <option
                            v-for="sede in sedes"
                            :key="sede.id"
                            :value="sede.id"
                          >
                            {{ sede.sedes }}
                          </option>
                        </select>
                      </div>
                      <div
                        :class="{
                          'form-group': true,
                          'col-sm-4': form_datos_usuario.modo == 'NUEVO',
                          'col-sm-6': form_datos_usuario.modo == 'EDITAR DOCTOR',
                        }"
                      >
                        <span
                          v-if="
                            submited && !$v.form_datos_usuario.id_cargo.noZero
                          "
                          class="span-error-message"
                        >
                          *
                        </span>
                        <label class="label-title">CARGO</label>

                        <select
                          type="text"
                          class="form-control"
                          style="max-width: 300px"
                          v-model="form_datos_usuario.id_cargo"
                          :disabled="true"
                        >
                          <option value="0">Seleccione...</option>
                          <option
                            v-for="cargo in cargos"
                            :key="cargo.id"
                            :value="cargo.id"
                          >
                            {{ cargo.cargo }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row"></div>
                    <div
                      class="form-row"
                      v-if="form_datos_usuario.modo == 'EDITAR DOCTOR'"
                    >
                      <div class="form-group col-sm-4">
                        <label
                          class="form-control-label label-title"
                          style="color: var(--colorGth2)"
                          >Acciones adicionales:</label
                        >
                        <button
                          class="btn btn-cancel btn-icon-split"
                          @click="EliminarUsuario"
                        >
                          <span class="icon text-white">
                            <i class="fas fa-user-slash text-white"></i>
                          </span>
                          <span class="text font-size-layout"
                            >Eliminar doctor</span
                          >
                        </button>
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
      </div>
    </div>
  </layout>
</template>

<script>
import layout from "../Components/layout_prin.vue";
import headerClose from "./../Components/header_close";
import { required } from "vuelidate/lib/validators";
const diferentThanZero = (value) => value != 0;
export default {
  components: { layout, headerClose },
  props: {
    usuarios: Array,
    sedes: Array,
    cargos: Array,
  },
  data() {
    return {
      windowWidth: window.innerWidth,
      submited: false,
      title_modal: null,
      txtdni_type: "number",
      form_datos_usuario: {
        modo: null,
        dni: null,
        especialidad: null,
        usuario: null,
        nombres: null,
        apellidoPaterno: null,
        apellidoMaterno: null,
        // genero: null,
        // direccion: null,
        clinica_uno: null,
        clinica_dos: null,
        telefono: null,
        id_cargo: null,
        id_sede: null,
        // habilitado: null,
      },
    };
  },
  validations() {
    if (
      this.form_datos_usuario.modo == "NUEVO DOCTOR"
    ) {
      return {
        form_datos_usuario: {
          dni: { required },
          usuario: { required },
          nombres: { required },
          apellidoPaterno: { required },
          apellidoMaterno: { required },
          // genero: { noZero: diferentThanZero },
          // direccion: { required },
          telefono: { required },
          id_cargo: { noZero: diferentThanZero },
          id_sede: { noZero: diferentThanZero },
        },
      };
    } else if (this.form_datos_usuario.modo == "EDITAR DOCTOR") {
      return {
        form_datos_usuario: {
          usuario: { required },
          nombres: { required },
          apellidoPaterno: { required },
          apellidoMaterno: { required },
          // genero: { noZero: diferentThanZero },
          // direccion: { required },
          telefono: { required },
          id_cargo: { noZero: diferentThanZero },
          id_sede: { noZero: diferentThanZero },
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
      if (new_val == "EDITAR DOCTOR") {
        this.txtdni_type = "text";
      } else if (new_val == "NUEVO USUARIO") {
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
          scrollX: true,
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
    NuevoDoctor() {
      this.submited = false;
      this.title_modal = "NUEVO DOCTOR";
      this.form_datos_usuario.dni = null;
      this.form_datos_usuario.usuario = null;
      this.form_datos_usuario.nombres = null;
      this.form_datos_usuario.apellidoPaterno = null;
      this.form_datos_usuario.apellidoMaterno = null;
      // this.form_datos_usuario.genero = 0;
      this.form_datos_usuario.clinica_uno = null;
      this.form_datos_usuario.clinica_dos = null;
      this.form_datos_usuario.telefono = null;
      this.form_datos_usuario.id_cargo = 1;
      this.form_datos_usuario.id_sede = 1;
      this.form_datos_usuario.modo = "NUEVO DOCTOR";

      $("#mdlDatosUsuario").css("display", "block");
      $("#datosUsuario1-tab").tab("show");
    },
    EditarUsuario(usuario) {
      this.submited = false;
      this.title_modal = "EDITAR DOCTOR";
      this.form_datos_usuario.dni = usuario.dni;
      this.form_datos_usuario.usuario = usuario.usuario;
      this.form_datos_usuario.especialidad = usuario.especialidad;
      this.form_datos_usuario.nombres = usuario.nombres;
      this.form_datos_usuario.apellidoPaterno = usuario.apellidoPaterno;
      this.form_datos_usuario.apellidoMaterno = usuario.apellidoMaterno;
      // this.form_datos_usuario.genero = usuario.genero;
      //   this.form_datos_usuario.direccion = usuario.direccion;
      this.form_datos_usuario.clinica_uno = usuario.clinica_uno;
      this.form_datos_usuario.clinica_dos = usuario.clinica_dos;
      this.form_datos_usuario.telefono = usuario.telefono;
      //   this.form_datos_usuario.correo = usuario.correo;
      this.form_datos_usuario.id_cargo = usuario.id_cargo;
      this.form_datos_usuario.id_sede = usuario.id_sede;

      this.form_datos_usuario.modo = "EDITAR DOCTOR";
      $("#mdlDatosUsuario").css("display", "block");
      $("#datosUsuario1-tab").tab("show");
      $("#btnCancelar").click(function () {
        $("#mdlDatosUsuario").css("display", "none");

        $("#datosUsuario1-tab").tab("show");
      });
    },
    EliminarUsuario() {
      self = this;
      Swal.fire({
        title: "ELIMINAR USUARIO",
        confirmButtonText:
          '<i class="fas fa-check" style="color:white;"></i>   Si',
        confirmButtonColor: "var(--colorAlto)",
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-times"></i>   No',
        cancelButtonColor: "var(--plomoOscuroEmpresarial)",
        showLoaderOnConfirm: true,
        preConfirm: (motivo_cese) => {
          let data = new FormData();
          data.append("dni", self.form_datos_usuario.dni);
          self.$inertia.post(route("usuarios_gestion.eliminar"), data, {
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
                  console.log("ya esta ");
                  self.submited = false;
                  self.Cerrar();
                  $("#tblUsuarios").DataTable().destroy();
                  self.TablaGestionUsuarios();
                },
              });
            },
          });
        },
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
        let data = new FormData();

        data.append("modo", this.form_datos_usuario.modo);
        data.append("dni", this.form_datos_usuario.dni);
        data.append("usuario", this.form_datos_usuario.usuario);
        // console.log(this.form_datos_usuario);
        axios
          .post(route("usuarios_gestion.verificar"), data)
          .then(function (response) {
            let resultado = response.data;
            if (resultado == "INCORRECTO_D") {
              Swal.fire({
                icon: "error",
                title: "¡Ups!",
                text: "El DNI ingresado, ya está registrado, intente nuevamente.",
              });
              return false;
            } else if (resultado == "INCORRECTO_U") {
              Swal.fire({
                icon: "error",
                title: "¡Ups!",
                text: "El USUARIO ingresado, ya está registrado, intente nuevamente.",
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
                  self.$inertia.post(
                    route("usuarios_gestion.guardar"),
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
                            console.log("ya esta ");
                            self.submited = false;
                            self.Cerrar();
                            $("#tblUsuarios").DataTable().destroy();
                            self.TablaGestionUsuarios();
                          },
                        });
                      },
                    }
                  );
                },
              });
            }
          });
      }
    },
  },
};
</script>

<style>
</style>