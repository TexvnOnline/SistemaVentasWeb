<template>
  <div id="mdlDatosActivo" class="modal">
    <div class="modal-content w-50">
      <div class="content" style="display: block">
        <div class="card">
          <div class="card-header">
            <div id="c_titulo">
              <strong id="title">{{ title_modal }}</strong>
            </div>
          </div>
          <div class="card-title">INFORMACIÓN DEl PRODUCTO</div>
          <div class="card-body card-block">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link active tab-title"
                  id="datosActivo1-tab"
                  data-toggle="tab"
                  href="#datosActivo1"
                  role="tab"
                  aria-controls="datosActivo1"
                  aria-="true"
                  >Datos básicos</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link tab-title"
                  id="datosActivo2-tab"
                  data-toggle="tab"
                  href="#datosActivo2"
                  role="tab"
                  aria-controls="datosActivo2"
                  aria-="false"
                  ><i class="fas fa-plus"></i
                ></a>
              </li>
            </ul>
            <form>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="datosActivo1"
                  role="tabpanel"
                  aria-labelledby="datosActivo1-tab"
                >
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="idAgencia"
                        >SEDE</label
                      >
                      <select
                        class="form-control"
                        id="idAgencia_crear"
                        name="agencia"
                        v-model="frmDatosActivo.id_sede"
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
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="idAgencia"
                        >PROVEEDOR</label
                      >
                      <select
                        class="form-control"
                        id="proveedor"
                        name="agencia"
                        v-model="frmDatosActivo.id_proveedor"
                      >
                        <option value="0" selected>Seleccione...</option>
                        <option
                          v-for="proveedor in proveedores"
                          :key="proveedor.id"
                          :value="proveedor.id"
                        >
                          {{ proveedor.nombre_empresa_razon_social }}
                        </option>
                      </select>
                      <div
                        v-if="
                          submited && !$v.frmDatosActivo.id_proveedor.noZero
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Seleccione una agencia
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="idAgencia"
                        >CATEGORIA</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="inpCategoria"
                        name="Categoria"
                        v-model="frmDatosActivo.categoria"
                      />
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="slcNombresActivo"
                        >NOMBRE DEL PRODUCTO</label
                      >
                      <textarea
                        class="form-control"
                        rows="1"
                        id="txtnombre"
                        name="nombre"
                        v-model="frmDatosActivo.nombre"
                      ></textarea>
                      <div
                        v-if="submited && !$v.frmDatosActivo.nombre.required"
                        style="color: red; font-size: 12px"
                      >
                        *Seleccione un nombre
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="idAgencia"
                        >COLOR</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="inpColor"
                        name="Color"
                        v-model="frmDatosActivo.color"
                      />
                    </div>

                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="slcTiposCrear"
                        >FECHA_ENTREGA</label
                      >

                      <input
                        class="form-control center"
                        type="date"
                        name="fechaInventariollegada"
                        id="dtpFechaInventariollegada"
                        onkeydown="return false"
                        v-model="frmDatosActivo.fecha_llegada"
                      />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label
                        class="form-control-label label-title"
                        for="txtDescripcion"
                        >DESCRIPCIÓN</label
                      >
                      <textarea
                        class="form-control"
                        rows="1"
                        id="txtDescripcion"
                        name="descripcion"
                        v-model="frmDatosActivo.descripcion"
                      ></textarea>
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="idAgencia"
                        >GÉNERO</label
                      >
                      <select
                        class="form-control center"
                        style="max-width: 200px"
                        v-model="frmDatosActivo.genero"
                      >
                        <option value="0">Seleccione...</option>
                        <option value="F">Femenino</option>
                        <option value="M">Masculino</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div
                  class="tab-pane fade"
                  id="datosActivo2"
                  role="tabpanel"
                  aria-labelledby="datosActivo2-tab"
                >
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="inpMarca"
                        >MARCA</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="inpMarca"
                        name="marca"
                        v-model="frmDatosActivo.marca"
                      />
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="inpModelo"
                        >TALLA</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="inpTalla"
                        name="talla"
                        v-model="frmDatosActivo.talla"
                      />
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="inpCantidad"
                        >CANTIDAD</label
                      >
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="font-size: 12px">
                            UNID.
                          </div>
                        </div>
                        <input
                          type="number"
                          class="form-control center"
                          id="inpCantidad"
                          name="cantidad"
                          min="1"
                          placeholder="0"
                          v-model.number="frmDatosActivo.cantidad"
                          @change="GenerarCodigo"
                          :disabled="
                            frmDatosActivo.modo == 'EDITAR' ||
                            title_modal == 'EDITAR COMPRA'
                          "
                        />
                        <div
                          v-if="
                            submited && !$v.frmDatosActivo.cantidad.required
                          "
                          style="color: red; font-size: 12px"
                        >
                          *Campo obligatorio
                        </div>
                        <div
                          v-if="
                            submited && !$v.frmDatosActivo.cantidad.onlyNumbers
                          "
                          style="color: red; font-size: 12px"
                        >
                          *Solo números
                        </div>
                        <div
                          v-if="submited && !$v.frmDatosActivo.cantidad.noZero"
                          style="color: red; font-size: 12px"
                        >
                          *La cantidad tiene que ser mayor a cero
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="inpValor"
                        >PRECIO COMPRA</label
                      >
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="font-size: 12px">
                            S/
                          </div>
                        </div>
                        <input
                          type="number"
                          class="form-control center"
                          id="inpValorCompra"
                          name="precio_compra"
                          min="1"
                          step="0.01"
                          lang="en"
                          placeholder="0.00"
                          v-model.number="frmDatosActivo.precio_compra"
                        />
                      </div>
                      <div
                        v-if="
                          submited && !$v.frmDatosActivo.precio_compra.required
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Campo obligatorio
                      </div>
                      <div
                        v-if="
                          submited &&
                          !$v.frmDatosActivo.precio_compra.onlyNumbers
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Solo números
                      </div>
                      <div
                        v-if="
                          submited && !$v.frmDatosActivo.precio_compra.noZero
                        "
                        style="color: red; font-size: 12px"
                      >
                        *El precio de compra tiene que ser mayor a cero
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label
                        class="form-control-label label-title"
                        for="inpValor"
                        >PRECIO SUGERIDO</label
                      >
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="font-size: 12px">
                            S/
                          </div>
                        </div>
                        <input
                          type="number"
                          class="form-control center"
                          id="inpValorSugerido"
                          name="precio_compra"
                          min="1"
                          step="0.01"
                          lang="en"
                          placeholder="0.00"
                          v-model.number="frmDatosActivo.precio_sugerido"
                        />
                      </div>
                      <div
                        v-if="
                          submited &&
                          !$v.frmDatosActivo.precio_sugerido.required
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Campo obligatorio
                      </div>
                      <div
                        v-if="
                          submited &&
                          !$v.frmDatosActivo.precio_sugerido.onlyNumbers
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Solo números
                      </div>
                      <div
                        v-if="
                          submited && !$v.frmDatosActivo.precio_sugerido.noZero
                        "
                        style="color: red; font-size: 12px"
                      >
                        *El precio sugerido tiene que ser mayor a cero
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <hr />
            <div class="text-right">
              <button
                class="btn btn-action btn-icon-split"
                id="btnGuardarActivo"
                @click="GuardarActivo()"
              >
                <span class="icon text-white">
                  <i class="fas fa-save"></i>
                </span>
                <span class="text font-size-layout">Guardar</span>
              </button>
              <button
                class="btn btn-cancel btn-icon-split"
                id="btnCancelarActivo"
                @click="CerrarModal()"
              >
                <span class="icon text-white">
                  <i class="fas fa-times"></i>
                </span>
                <span class="text font-size-layout">Cancelar</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { component } from 'vue/types/umd';
import { required } from "vuelidate/lib/validators";
const noZero = (value) => value != 0;
const onlyNumbers = (value) =>
  Number.isInteger(value) || value - Math.floor(value) !== 0;
export default {
  props: {
    ultimo_activo: Array,
    sedes: Array,
    productos: Array,
    proveedores: Array,
  },
  data() {
    return {
      submited: false,
      title_modal: null,
      contador_activos: this.ultimo_activo[0].numero_activo,
      frmDatosActivo: {
        modo: null,
        item: null,
        nombre: null,
        id_sede: null,
        id_proveedor: null,
        categoria: null,
        cantidad: null,
        color: null,
        genero: null,
        marca: null,
        talla: null,
        numero_activo: [],
        codigo_relacionado: [],
        descripcion: null,
        fecha_pedido: null,
        fecha_llegada: null,
        precio_compra: null,
        precio_sugerido: null,
      },
      frmCanastaCompras: {
        modo: "NUEVO",
        usuario_compra: null,
        canasta: [],
      },
    };
  },
  validations: {
    frmDatosActivo: {
      id_sede: { noZero },
      id_proveedor: { noZero },
      nombre: { required },
      // fecha_pedido: { required },
      cantidad: { required, onlyNumbers, noZero },
      precio_sugerido: { required, onlyNumbers, noZero },
      precio_compra: { required, onlyNumbers, noZero },
    },
  },
  methods: {
    roundTo(value, places) {
      if (value > 0 && value != "Infinity") {
        var power = Math.pow(10, places);
        return parseFloat(Math.round(value * power) / power).toFixed(2);
      } else {
        return 0;
      }
    },
    CerrarModal() {
      $("#datosActivo1-tab").tab("show");
      $("#mdlDatosActivo").css("display", "none");
    },
    GenerarCodigo(e) {
      let self = this;
      let ultimo = null;

      let proveedores = this.proveedores.filter(
        (item) => item.id == self.frmDatosActivo.id_proveedor
      )[0].nombre_empresa;

      if (this.title_modal == "NUEVA COMPRA") {
        this.frmDatosActivo.codigo_relacionado = [];
        this.frmDatosActivo.numero_activo = [];
        if (this.frmCanastaCompras.canasta.length == 0) {
          this.contador_activos = parseInt(this.ultimo_activo[0].numero_activo);
          // console.log(this.contador_activos);
        } else if (this.frmCanastaCompras.canasta.length > 0) {
          self.contador_activos = parseInt(
            this.frmCanastaCompras.canasta[
              this.frmCanastaCompras.canasta.length - 1
            ].numero_activo
          );
          // console.log(this.contador_activos);
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
        let codigo_relacionado = proveedores + "-";
        this.frmDatosActivo.codigo_relacionado[0] = codigo_relacionado;
      }
    },
    ActualizarTablaInventario() {
      let mdlCanastaCompras = this.$parent.$parent.$refs.mdlCanastaCompras;
      console.log(mdlCanastaCompras);
      console.log($("#tblInventarioActivos").DataTable().destroy());
      // $("#tblInventarioActivos").DataTable().destroy();
      this.$parent.$parent.$refs.mdlCanastaCompras.TablaInventarioActivos();
    },
    GuardarActivo() {
      this.submited = true;
      let self = this;

      let empresa_nombre = null;

      if (this.title_modal == "NUEVA COMPRA") {
        if (this.$v.frmDatosActivo.$invalid) {
          return false;
        } else {
          Swal.fire({
            title: "AGREGAR A CANASTA",
            text: "¿Desea continuar?",
            confirmButtonText:
              '<i class="fas fa-check" style="color:white;"></i>   Si',
            confirmButtonColor: "var(--colorAlto)",
            showCancelButton: true,
            cancelButtonText: '<i class="fas fa-times"></i>   No',
            cancelButtonColor: "var(--plomoOscuroEmpresarial)",
            allowOutsideClick: false,
            preConfirm: (result) => {
              let numero_activo = null;

              self.frmDatosActivo.codigo_relacionado.forEach(
                (element, index) => {
                  // console.log(index);
                  let item = self.contador_canasta;
                  self.contador_canasta += 1;

                  empresa_nombre = this.proveedores.filter(
                    (item) => item.id == self.frmDatosActivo.id_proveedor
                  )[0].nombre_empresa_razon_social;

                  console.log(empresa_nombre);
                  numero_activo = self.frmDatosActivo.numero_activo[index];

                  var objeto = {
                    item: item,
                    // Datos para tabla
                    id_proveedor: self.frmDatosActivo.id_proveedor,
                    empresa_nombre: empresa_nombre,
                    numero_activo: numero_activo,
                    codigo_relacionado: element,
                    cantidad: 1,
                    nombre: self.frmDatosActivo.nombre,
                    precio_compra: self.frmDatosActivo.precio_compra,
                    precio_sugerido: self.frmDatosActivo.precio_sugerido,
                    // Datos adicionales
                    id_sede: self.frmDatosActivo.id_sede,
                    fecha_pedido: self.frmDatosActivo.fecha_pedido,
                    fecha_llegada: self.frmDatosActivo.fecha_llegada,
                    descripcion: self.frmDatosActivo.descripcion,
                    marca: self.frmDatosActivo.marca,
                    talla: self.frmDatosActivo.talla,
                    color: self.frmDatosActivo.color,
                    categoria: self.frmDatosActivo.categoria,
                    genero: self.frmDatosActivo.genero,
                  };
                  self.frmCanastaCompras.canasta.push(objeto);
                }
              );

              // Destroy dataTable
              let mdlCanastaCompras =
                self.$parent.$parent.$refs.mdlCanastaCompras;
              $("#tblCanastaCompras").DataTable().destroy();
              mdlCanastaCompras.TablaCanastaCompras();
              $("#mdlDatosActivo").css("display", "none");
              self.submited = false;
            },
          });
        }
      } else if (this.title_modal == "EDITAR COMPRA") {
        if (this.$v.frmDatosActivo.$invalid) {
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
            preConfirm: (result) => {
              empresa_nombre = this.proveedores.filter(
                (item) => item.id == self.frmDatosActivo.id_proveedor
              )[0].nombre_empresa;

              self.$set(
                self.frmCanastaCompras.canasta,
                self.frmCanastaCompras.canasta.findIndex(
                  (f) => f.item == self.frmDatosActivo.item
                ),
                {
                  // Datos para tabla
                  id_proveedor: self.frmDatosActivo.id_proveedor,
                  empresa_nombre: empresa_nombre,
                  nombre: self.frmDatosActivo.nombre,
                  numero_activo: numero_activo,
                  codigo_relacionado: element,
                  cantidad: 1,
                  precio_compra: self.frmDatosActivo.precio_compra,
                  precio_sugerido: self.frmDatosActivo.precio_sugerido,
                  // Datos adicionales
                  id_sede: self.frmDatosActivo.id_sede,
                  fecha_pedido: self.frmDatosActivo.fecha_pedido,
                  fecha_llegada: self.frmDatosActivo.fecha_llegada,
                  descripcion: self.frmDatosActivo.descripcion,
                  marca: self.frmDatosActivo.marca,
                  talla: self.frmDatosActivo.talla,
                  color: self.frmDatosActivo.color,
                  categoria: self.frmDatosActivo.categoria,
                  genero: self.frmDatosActivo.genero,
                }
              );
              // Destroy dataTable
              let mdlCanastaCompras =
                self.$parent.$parent.$refs.mdlCanastaCompras;
              $("#tblCanastaCompras").DataTable().destroy();
              mdlCanastaCompras.TablaCanastaCompras();
              $("#mdlDatosActivo").css("display", "none");
              self.submited = false;
            },
          });
        }
      } else if (self.frmDatosActivo.modo == "EDITAR") {
        if (this.$v.frmDatosActivo.$invalid) {
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
            preConfirm: (result) => {
              let data = new FormData();
              data.append("tipo_modulo", self.tipo_modulo);
              data.append(
                "frmDatosActivo",
                JSON.stringify(self.frmDatosActivo)
              );
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
                      $("#tblInventarioActivos").DataTable().destroy();
                      self.$parent.$parent.TablaInventarioActivos();
                      $("#mdlDatosActivo").css("display", "none");
                    },
                  });
                },
              });
            },
          });
        }
      }
    },
  },
};
</script>

<style></style>
