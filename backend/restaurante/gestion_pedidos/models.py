from django.db import models

# Create your models here.
class Usuario(models.Model):
    nombre = models.CharField(max_length=100)
    email = models.EmailField(unique=True)
    contraseña = models.CharField(max_length=255)
    rol = models.CharField(max_length=50, choices=[('admin', 'Administrador'), ('cocina', 'Cocina'), ('cliente', 'Cliente')])

class Item(models.Model):
    nombre = models.CharField(max_length=100)
    descripcion = models.TextField(null=True, blank=True)
    precio = models.DecimalField(max_digits=10, decimal_places=2)
    disponible = models.BooleanField(default=True)

class Pedido(models.Model):
    usuario = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    mesa = models.IntegerField()
    estado = models.CharField(max_length=50, default='activo')
    total = models.DecimalField(max_digits=10, decimal_places=2)

class Factura(models.Model):
    pedido = models.OneToOneField(Pedido, on_delete=models.CASCADE)
    fecha = models.DateTimeField(auto_now_add=True)
    total = models.DecimalField(max_digits=10, decimal_places=2)

class Transaccion(models.Model):
    pedido = models.ForeignKey(Pedido, on_delete=models.CASCADE)
    monto = models.DecimalField(max_digits=10, decimal_places=2)
    metodo_pago = models.CharField(max_length=50)
    fecha = models.DateTimeField(auto_now_add=True)

class PedidoItem(models.Model):
    pedido = models.ForeignKey(Pedido, on_delete=models.CASCADE)
    item = models.ForeignKey(Item, on_delete=models.CASCADE)
    cantidad = models.IntegerField()
    personalizacion = models.TextField(null=True, blank=True)
