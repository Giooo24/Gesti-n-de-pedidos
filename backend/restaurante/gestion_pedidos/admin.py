from django.contrib import admin

# Register your models here.
from .models import Usuario, Item, Pedido, Factura, Transaccion, PedidoItem

admin.site.register(Usuario)
admin.site.register(Item)
admin.site.register(Pedido)
admin.site.register(Factura)
admin.site.register(Transaccion)
admin.site.register(PedidoItem)
