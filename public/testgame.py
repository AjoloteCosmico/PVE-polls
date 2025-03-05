import pygame
import sys

# Inicializar pygame
pygame.init()

# Configuración de la pantalla
width, height = 800, 600
screen = pygame.display.set_mode((width, height))
pygame.display.set_caption("Pong")

# Colores
black = (0, 0, 0)
white = (255, 255, 255)

# Paletas y pelota
paddle_width, paddle_height = 10, 100
ball_size = 20

# Posiciones iniciales
paddle1 = pygame.Rect(30, height // 2 - paddle_height // 2, paddle_width, paddle_height)
paddle2 = pygame.Rect(width - 30 - paddle_width, height // 2 - paddle_height // 2, paddle_width, paddle_height)
ball = pygame.Rect(width // 2 - ball_size // 2, height // 2 - ball_size // 2, ball_size, ball_size)

# Velocidades
ball_speed_x, ball_speed_y = 7, 7
paddle_speed = 10

# Puntuación
score1, score2 = 0, 0
font = pygame.font.Font(None, 74)

# Bucle principal del juego
clock = pygame.time.Clock()
running = True
while running:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False

    # Movimiento de las paletas
    keys = pygame.key.get_pressed()
    if keys[pygame.K_w] and paddle1.top > 0:
        paddle1.y -= paddle_speed
    if keys[pygame.K_s] and paddle1.bottom < height:
        paddle1.y += paddle_speed
    if keys[pygame.K_UP] and paddle2.top > 0:
        paddle2.y -= paddle_speed
    if keys[pygame.K_DOWN] and paddle2.bottom < height:
        paddle2.y += paddle_speed

    # Movimiento de la pelota
    ball.x += ball_speed_x
    ball.y += ball_speed_y

    # Colisiones con las paredes (arriba y abajo)
    if ball.top <= 0 or ball.bottom >= height:
        ball_speed_y *= -1

    # Colisiones con las paletas
    if ball.colliderect(paddle1) or ball.colliderect(paddle2):
        ball_speed_x *= -1

    # Puntuación
    if ball.left <= 0:
        score2 += 1
        
        ball.x, ball.y = width // 2 - ball_size // 2, height // 2 - ball_size // 2
        ball_speed_x *= -1
        pygame.time.delay(1000)
    if ball.right >= width:
        score1 += 1
        ball.x, ball.y = width // 2 - ball_size // 2, height // 2 - ball_size // 2
        ball_speed_x *= -1
        pygame.time.delay(1000)


    # Dibujar en pantalla
    screen.fill(black)
    pygame.draw.rect(screen, white, paddle1)
    pygame.draw.rect(screen, white, paddle2)
    pygame.draw.ellipse(screen, white, ball)
    pygame.draw.aaline(screen, white, (width // 2, 0), (width // 2, height))

    # Mostrar puntuación
    score_text = font.render(f"{score1} : {score2}", True, white)
    screen.blit(score_text, (width // 2 - 50, 10))

    # Actualizar pantalla
    pygame.display.flip()
    clock.tick(60)

# Salir del juego
pygame.quit()
sys.exit()