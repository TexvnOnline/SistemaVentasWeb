<template>
  <div id="mdlCanastaCompras" class="modal">
    <div class="modal-content w-50">
      <div class="content" style="display: block">
        <div class="card">
          <div class="card-header">
            <div id="c_titulo">
              <strong id="title">{{ title_modal }}</strong>
            </div>
            <!-- <strong>CANASTA DE COMPRAS</strong> -->
          </div>
          <div class="card-body card-block">
            <div class="form-row">
              <button
                class="btn btn-action btn-icon-split mb-2"
                data-toggle="modal"
                @click="AgregarActivos"
              >
                <span class="icon">
                  <i class="fas fa-plus" style="color: white"></i>
                </span>
                <span class="text font-size-layout">Agregar</span>
              </button>
            </div>
            <div
              v-if="submited && !$v.frmCanastaCompras.canasta.required"
              style="color: red; font-size: 12px"
            >
              *Debe agregar al menos un activo
            </div>
            <table class="table table-hover table-responsive" id="tblCanastaCompras">
              <thead>
                <tr>
                  <th>ACCIONES</th>
                  <th>NOMBRE</th>
                  <th>CANTIDAD</th>
                  <th>FECHA_INGRESO</th>
                  <th>TALLA</th>
                  <th>PRECIO_COMPRA</th>
                  <th>PRECIO_SUGERIDO</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(compra, index) in frmCanastaCompras.canasta" :key="index">
                  <td class="table-bordered" align="center" width="75px">
                    <div class="text-center">
                      <div class="btn-group" role="group">
                        <button
                          class="btn btn-action"
                          type="button"
                          @click="EliminarCompra(index)"
                        >
                          <span class="icon text-white">
                            <i class="fas fa-trash-alt"></i>
                          </span>
                        </button>
                        <button
                          class="btn btn-cancel"
                          type="button"
                          @click="EditarCompra(compra)"
                        >
                          <span class="icon text-white">
                            <i class="fas fa-edit"></i>
                          </span>
                        </button>
                      </div>
                    </div>
                  </td>

                  <td class="table-bordered" align="center" width="100px">
                    {{ compra.nombre }}
                  </td>
                  <td class="table-bordered">
                    {{ compra.cantidad }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ compra.fecha_llegada = null ? " - " : compra.fecha_llegada}}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ compra.talla = null ? " - " : compra.talla}}
                  </td>
                  <td class="table-bordered" align="center">
                    S/ {{ roundTo(compra.precio_compra, 2) }}
                  </td>
                  <td class="table-bordered" align="center">
                    S/ {{ roundTo(compra.precio_sugerido, 2) }}
                  </td>
                </tr>
              </tbody>
            </table>
            <form>
              <div class="form-row">

                <div class="form-group col-md-4 offset-md-4">
                  <label
                    for="cmbUsuariosCompraNuevo"
                    class="form-control-label label-title"
                    >USUARIO DE COMPRA</label
                  >
                  <select
                    class="form-control"
                    name="agenciasCanasta"
                    id="cmbAgenciasCanasta"
                    style="max-width: 200px; margin-bottom: 10px"
                    @change="FiltrarAgenciaUsuario"
                  >
                    <option :value="0">Todas</option>
                    <option
                      v-for="agencia in sedes"
                      :key="agencia.id"
                      :value="agencia.id"
                    >
                      {{ agencia.sedes }}
                    </option>
                  </select>
                  <select
                    class="form-control"
                    name="usuariosCanasta"
                    id="cmbUsuariosCanasta"
                    style="max-width: 200px"
                    v-model="frmCanastaCompras.usuario_compra"
                  >
                    <option :value="0">Seleccione...</option>
                    <option
                      v-for="usuario in usuarios_filtrados"
                      :key="usuario.dni"
                      :value="usuario.dni"
                    >
                      {{ usuario.usuario }}
                      
                    </option>
                  </select>
                  <div
                    v-if="submited && !$v.frmCanastaCompras.usuario_compra.noZero"
                    style="color: red; font-size: 12px"
                  >
                    *Seleccione el usuario de compra
                  </div>
                </div>
              </div>
            </form>
            <hr />
            <div class="text-right">
              <button
                class="btn btn-action btn-icon-split font-size-layout"
                value="Guardar"
                @click="RegistrarCanastaCompras()"
              >
                <span class="icon text-white">
                  <i class="fas fa-save"></i>
                </span>
                <span class="text">Registrar</span>
              </button>
              <button
                class="btn btn-cancel btn-icon-split font-size-layout"
                type="button"
                id="btnCancelarCanasta"
                @click="CerrarModal()"
              >
                <span class="icon text-white">
                  <i class="fas fa-times"></i>
                </span>
                <span class="text">Cancelar</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
const noZero = (value) => value != 0;
export default {
  props: {
    ultimo_activo: Array,
    sedes: Array,
    usuarios: Array,
  },
  data() {
    return {
      submited: false,
      title_modal: null,
      usuarios_filtrados: this.usuarios,
      contador_activos: this.ultimo_activo[0].numero_activo,
      contador_canasta: 0,
      detalles_filtrados: [],
      frmCanastaCompras: {
        modo: "NUEVO",
        usuario_compra: null,
        canasta: [],
      },
    };
  },
  validations: {
    frmCanastaCompras: {
      usuario_compra: { noZero },
      canasta: { required },
    },
  },
  watch: {
    activos_filtrados() {
      $("#tblInventarioActivos").DataTable().destroy();
      this.TablaInventarioActivos();
    },
  },
  // mounted() {
  //   let inventario = this.$parent.$parent.FiltrarResponsableUbicacion();
  //   console.log(inventario);
  // },
  methods: {
    roundTo(value, places) {
      if (value > 0 && value != "Infinity") {
        var power = Math.pow(10, places);
        return parseFloat(Math.round(value * power) / power).toFixed(2);
      } else {
        return 0;
      }
    },
    AgregarActivos() {
      let self = this;
      let mdlDatosActivo = this.$parent.$parent.$refs.mdlDatosActivo;
      mdlDatosActivo.submited = false;
      // this.

      mdlDatosActivo.title_modal = "NUEVA COMPRA";
      // Por defecto la agencia es Administrativa'
      mdlDatosActivo.frmDatosActivo.id_sede = 0;
      // // Por defecto el responsable es 'LOGÍSTICA-RESPONSABLE en el área administrativa'
      // mdlDatosActivo.frmDatosActivo.id_responsable = 1;
      // // Por defecto la ubicación es 'LOGÍSTICA-ALMACEN' en el área administrativa'
      // mdlDatosActivo.frmDatosActivo.id_ubicacion = 1;
      // // -----------------------------------------------
      mdlDatosActivo.frmDatosActivo.modo = "NUEVO";
      mdlDatosActivo.frmDatosActivo.nombre = null;
      mdlDatosActivo.frmDatosActivo.id_proveedor = 0;
      mdlDatosActivo.frmDatosActivo.fecha_pedido = null;
      mdlDatosActivo.frmDatosActivo.fecha_llegada = null;
      mdlDatosActivo.frmDatosActivo.color = null;
      mdlDatosActivo.frmDatosActivo.categoria = null;
      mdlDatosActivo.frmDatosActivo.genero = 0;
      mdlDatosActivo.frmDatosActivo.descripcion = null;
      mdlDatosActivo.frmDatosActivo.numero_activo = [];
      mdlDatosActivo.frmDatosActivo.marca = null;
      mdlDatosActivo.frmDatosActivo.talla = null;
      mdlDatosActivo.frmDatosActivo.cantidad = 0;
      mdlDatosActivo.frmDatosActivo.precio_compra = null;
      mdlDatosActivo.frmDatosActivo.precio_sugerido = null;

      mdlDatosActivo.frmCanastaCompras = this.frmCanastaCompras;

      $("#mdlDatosActivo").css("display", "block");
      $("#datosActivo1-tab").tab("show");
      // $("#btnCancelarActivo").click(function () {
      //   $("#datosActivo1-tab").tab("show");
      //   $("#mdlDatosActivo").css("display", "none");

      //   self.submited = false;
      // });
    },
    TablaCanastaCompras() {
      this.$nextTick(() => {
        var table = $("#tblCanastaCompras").DataTable({
          destroy: true,
          lengthMenu: [
            [10, 50, 100],
            [10, 50, 100],
          ],
          order: [[1, "asc"]],
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
          dom: "frtp",
        });
      });
    },
    GenerarCodigo(e) {
      let self = this;
      // let ultimo = null;
      // let tipo = "";

      // let nombre = "";

      

      if (this.title_modal == "NUEVA COMPRA") {
        // this.frmDatosActivo.codigo_relacionado = [];
        this.frmDatosActivo.numero_activo = [];
        if (this.frmCanastaCompras.canasta.length == 0) {
          this.contador_activos = parseInt(this.ultimo_activo[0].numero_activo);
        } else if (this.frmCanastaCompras.canasta.length > 0) {
          self.contador_activos = parseInt(
            this.frmCanastaCompras.canasta[this.frmCanastaCompras.canasta.length - 1]
              .numero_activo
          );
        }

        for (let index = 0; index < self.frmDatosActivo.cantidad; index++) {
          self.contador_activos += 1;
        let codigo_relacionado = proveedores + "-";

          self.frmDatosActivo.codigo_relacionado.push(codigo_relacionado);
          self.frmDatosActivo.numero_activo.push(self.contador_activos);
        }
      } else if (
        this.title_modal == "EDITAR COMPRA" ||
        this.frmDatosActivo.modo == "EDITAR"
      ) {
        ultimo = this.frmDatosActivo.numero_activo;
        // let codigo_relacionado =
        //   tipo + "-" + responsable + "-" + ubicacion + "-" + ultimo + "-" + nombre;
        // this.frmDatosActivo.codigo_relacionado[0] = codigo_relacionado;
      }
    },
    EliminarCompra(index) {
      let self = this;
      Swal.fire({
        icon: "warning",
        title: "BORRAR COMPRA",
        text: "¿Desea continuar?",
        confirmButtonText: '<i class="fas fa-check" style="color:white;"></i>   Si',
        confirmButtonColor: "var(--colorAlto)",
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-times"></i>   No',
        cancelButtonColor: "var(--plomoOscuroEmpresarial)",
        allowOutsideClick: false,
        preConfirm: (result) => {
          self.frmCanastaCompras.canasta.splice(index, 1);
          $("#tblCanastaCompras").DataTable().destroy();
          self.TablaCanastaCompras();
        },
      });
    },
    EditarCompra(compra) {
      let mdlDatosActivo = this.$parent.$parent.$refs.mdlDatosActivo;
      mdlDatosActivo.title_modal = "EDITAR COMPRA";
      mdlDatosActivo.submited = false;

      mdlDatosActivo.frmDatosActivo.item = compra.item;
      mdlDatosActivo.frmDatosActivo.id_agencia = compra.id_agencia;
      mdlDatosActivo.frmDatosActivo.id_responsable = compra.id_responsable;
      mdlDatosActivo.frmDatosActivo.id_ubicacion = compra.id_ubicacion;
      mdlDatosActivo.frmDatosActivo.id_nombre = compra.id_nombre;
      mdlDatosActivo.frmDatosActivo.fecha = compra.fecha;
      mdlDatosActivo.frmDatosActivo.id_tipo = compra.id_tipo;
      mdlDatosActivo.frmDatosActivo.descripcion = compra.descripcion;
      mdlDatosActivo.frmDatosActivo.numero_activo = compra.numero_activo;
      mdlDatosActivo.frmDatosActivo.codigo_relacionado = [];
      mdlDatosActivo.frmDatosActivo.codigo_relacionado[0] = compra.codigo_relacionado;
      mdlDatosActivo.frmDatosActivo.marca = compra.marca;
      mdlDatosActivo.frmDatosActivo.modelo = compra.modelo;
      mdlDatosActivo.frmDatosActivo.placa = compra.placa;
      mdlDatosActivo.frmDatosActivo.caracteristicas = compra.caracteristicas;
      mdlDatosActivo.frmDatosActivo.id_estado = compra.id_estado;
      mdlDatosActivo.frmDatosActivo.cantidad = compra.cantidad;
      mdlDatosActivo.frmDatosActivo.color = compra.color;
      mdlDatosActivo.frmDatosActivo.valor = compra.valor;
      mdlDatosActivo.frmDatosActivo.vida_util = compra.vida_util;
      mdlDatosActivo.frmDatosActivo.depreciacion = compra.depreciacion;

      mdlDatosActivo.frmCanastaCompras = this.frmCanastaCompras;
      mdlDatosActivo.GenerarCodigo();
      $("#mdlDatosActivo").css("display", "block");
      $("#datosActivo1-tab").tab("show");
      // $("#btnCancelarActivo").click(function () {
      //   $("#datosActivo1-tab").tab("show");
      //   $("#mdlDatosActivo").css("display", "none");
      // });
    },
    FiltrarAgenciaUsuario(e) {
      let control_name = e.target.name;
      let id_agencia = e.target.value;
      // console.log(this.usuarios_filtrados);

      if (id_agencia == 0) {
        this.usuarios_filtrados = this.usuarios;
      } else {
        this.usuarios_filtrados = this.usuarios.filter(
          (item) => item.id_sede == id_agencia
        );
        // console.log(this.usuarios_filtrados);
      }
    },
    ActualizarTabla() {
      $("#tblCanastaCompras").DataTable().destroy();
      this.TablaCanastaCompras();
    },
    RegistrarCanastaCompras() {
      let self = this;
      this.submited = true;
      if (this.$v.frmCanastaCompras.$invalid) {
        console.log("hola");
        return false;
      } else {
        Swal.fire({
          title: "REGISTRAR COMPRA",
          text: "¿Desea continuar?",
          confirmButtonText: '<i class="fas fa-check" style="color:white;"></i>   Si',
          confirmButtonColor: "var(--colorAlto)",
          showCancelButton: true,
          cancelButtonText: '<i class="fas fa-times"></i>   No',
          cancelButtonColor: "var(--plomoOscuroEmpresarial)",
          allowOutsideClick: false,
          preConfirm: (result) => {
            let data = new FormData();
            data.append("usuario_compra", self.frmCanastaCompras.usuario_compra);
            data.append("modo", self.frmCanastaCompras.modo);
            data.append("canasta", JSON.stringify(self.frmCanastaCompras.canasta));
// console.log(data);
            self.$inertia.post(route("sistema.almacen.guardar"), data, {
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
                    self.$parent.$parent.frmCanastaCompras.canasta = [];
                    self.frmCanastaCompras.canasta = [];
                    self.ActualizarTabla();
                    $("#mdlCanastaCompras").css("display", "none");
                  },
                });
              },
            });
          },
        });
      }
    },
    CerrarModal() {
      $("#datosActivo1-tab").tab("show");
      $("#mdlCanastaCompras").css("display", "none");
    },
  },
};
</script>

<style></style>
