from rest_framework.routers import DefaultRouter
from .views import (
    UsuarioViewSet, ItemViewSet, PedidoViewSet,
    FacturaViewSet, TransaccionViewSet, PedidoItemViewSet
)

router = DefaultRouter()
router.register(r'usuarios', UsuarioViewSet)
router.register(r'items', ItemViewSet)
router.register(r'pedidos', PedidoViewSet)
router.register(r'facturas', FacturaViewSet)
router.register(r'transacciones', TransaccionViewSet)
router.register(r'pedido-items', PedidoItemViewSet)

urlpatterns = router.urls

